<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';

function ttp_build_member_tree(array $rows, ?int $parentId = null): array {
    $branch = [];
    foreach ($rows as $row) {
        $rowParent = $row['parent_id'] !== null ? (int)$row['parent_id'] : null;
        if ($rowParent !== $parentId) {
            continue;
        }
        $branch[] = [
            'id' => (int)$row['id'],
            'title' => $row['title'],
            'name' => $row['name'],
            'photo' => asset_url($row['photo']),
            'certificate' => asset_url($row['certificate']),
            'children' => ttp_build_member_tree($rows, (int)$row['id']),
        ];
    }
    return $branch;
}

function regenerate_turkey_map_data(): void {
    $provinces = require __DIR__ . '/provinces.php';
    $pdo = db();

    $reps = [];
    foreach ($pdo->query('SELECT * FROM representatives') as $row) {
        $reps[$row['plate']] = $row;
    }

    $membersByPlate = [];
    foreach ($pdo->query('SELECT * FROM representative_members ORDER BY sort_order, id') as $row) {
        $membersByPlate[$row['plate']][] = $row;
    }

    $coords = $pdo->query('SELECT * FROM region_coordinators ORDER BY sort_order, id')->fetchAll();

    $lines = [];
    $coordList = array_map(function ($c) {
        return [
            'title' => $c['title'],
            'name' => $c['name'],
            'photo' => asset_url($c['photo']),
            'certificate' => asset_url($c['certificate']),
        ];
    }, $coords);
    $lines[] = 'window.TTP_REGIONAL_COORDINATORS = ' . json_encode($coordList, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . ';';
    $lines[] = '';
    $lines[] = 'window.TURKEY_PROVINCES_DATA = {';

    $entries = [];
    foreach ($provinces as $plate => $p) {
        $rep = $reps[$plate] ?? null;
        $hasRep = $rep !== null;
        $entry = [
            'id' => $p['id'],
            'name' => $p['name'],
            'plate' => (string)$plate,
            'region' => $p['region'],
            'hasRepresentative' => $hasRep,
            'hierarchy' => $hasRep ? [
                'president' => [
                    'title' => $rep['title'],
                    'name' => $rep['name'],
                    'photo' => asset_url($rep['photo']),
                    'certificate' => asset_url($rep['certificate']),
                ],
                'children' => ttp_build_member_tree($membersByPlate[$plate] ?? []),
            ] : null,
        ];
        $json = json_encode($entry, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $json = preg_replace('/^/m', '  ', $json);
        $entries[] = '  "' . $plate . '": ' . ltrim($json);
    }
    $lines[] = implode(",\n", $entries);
    $lines[] = '};';
    $lines[] = '';

    $target = dirname(__DIR__, 2) . '/assets/js/turkey-map-data.js';
    file_put_contents($target, implode("\n", $lines));
}

