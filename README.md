# Terörsüz Türkiye Platformu

Public site and `/admin` panel. Pages are PHP, served by Apache. Clean URLs and security headers come from `.htaccess`. Content is stored in MySQL (or MariaDB).

The database connection is read from environment variables in `admin/includes/db.php`:

| Setting | Variable names, first match wins | Local default |
| --- | --- | --- |
| Host | `DB_HOST`, `MYSQLHOST` | `localhost` |
| Port | `DB_PORT`, `MYSQLPORT` | `3306` |
| Database | `DB_NAME`, `MYSQLDATABASE` | `ttp_admin` |
| User | `DB_USER`, `MYSQLUSER` | `root` |
| Password | `DB_PASS`, `MYSQLPASSWORD` | empty |

If `MYSQL_URL` or `DATABASE_URL` is set to a `mysql://user:pass@host:port/dbname` URL, that URL is used on its own.

Schema and seed data are in `veritabani.sql`. Apache blocks direct download of `.sql` and `.md` files.

## Requirements

- PHP 8.2 or newer, with the `pdo_mysql`, `gd`, and `curl` extensions
- Apache with `mod_rewrite` and `mod_headers`
- MySQL 8 or MariaDB 10.4 or newer

`Dockerfile` in the repo root builds this stack from `php:8.3-apache` and listens on the `PORT` value Render and Railway inject.

## Run locally

1. Create a database named `ttp_admin` and import the dump:

   ```bash
   mysql -u root -p -e "CREATE DATABASE ttp_admin CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci;"
   mysql -u root -p ttp_admin < veritabani.sql
   ```

2. Point Apache at this folder with `AllowOverride All` so `.htaccess` runs. Open the site at the vhost URL.
3. Open `/admin/login.php`. The dump includes the `admin` user from this project. After the first login, change the password at `/admin/password.php`.

To set a new password before you know the current one, generate a hash and update the row:

```bash
php -r "echo password_hash('choose-a-long-password', PASSWORD_DEFAULT), PHP_EOL;"
```

```sql
UPDATE admin_users SET password_hash = 'paste-the-hash-here' WHERE username = 'admin';
```

## Deploy on Render

Render has no built-in PHP runtime. This repo deploys as a Docker web service. MySQL runs as a separate private service. Commit and push `Dockerfile` before you connect the repo.

### 1. Put the code on GitHub

The remote is `https://github.com/akartek-resmi/Terorsuz_Turkiye_Platformu.git`. Push the branch you want to deploy (usually `main`).

### 2. Create the MySQL service

Follow [Deploy MySQL](https://render.com/docs/deploy-mysql):

1. Fork [render-examples/mysql](https://github.com/render-examples/mysql). The `master` branch is MySQL 8.
2. In the [Render Dashboard](https://dashboard.render.com), choose **New → Private Service** and connect that fork.
3. Set **Language** to **Docker**.
4. Add these environment variables:

   | Key | Value |
   | --- | --- |
   | `MYSQL_DATABASE` | `ttp_admin` |
   | `MYSQL_USER` | a username you choose, for example `ttp` |
   | `MYSQL_PASSWORD` | a long random password |
   | `MYSQL_ROOT_PASSWORD` | a different long random password |

5. Under **Advanced → Disks**, add a disk:

   | Field | Value |
   | --- | --- |
   | Mount Path | `/var/lib/mysql` |
   | Size | `10 GB` (or whatever you need) |

   The mount path has to be `/var/lib/mysql`. A different path leaves the data on the container disk, and the next deploy wipes it.

6. Create the service and wait until it is live. Copy the internal address. It looks like `mysql-xxxx:3306`. The host is the part before the colon, and the port is `3306`.

### 3. Create the web service

1. **New → Web Service**.
2. Connect `akartek-resmi/Terorsuz_Turkiye_Platformu`.
3. Render sees `Dockerfile` and uses Docker. Leave the Dockerfile path as `Dockerfile` and the branch as `main`.
4. Pick a region close to the MySQL service. Both services need to be in the same region so the private hostname resolves.
5. Add environment variables. Use the host from step 2 and the same database name, user, and password:

   | Key | Value |
   | --- | --- |
   | `DB_HOST` | `mysql-xxxx` (no port) |
   | `DB_PORT` | `3306` |
   | `DB_NAME` | `ttp_admin` |
   | `DB_USER` | the `MYSQL_USER` value |
   | `DB_PASS` | the `MYSQL_PASSWORD` value |

6. Choose an instance type and create the service. Render builds the image and starts Apache on the `PORT` it assigns.

### 4. Import the database

1. Open the web service and choose **Shell**.
2. Run:

   ```bash
   mysql -h "$DB_HOST" -P "$DB_PORT" -u "$DB_USER" -p"$DB_PASS" "$DB_NAME" < /var/www/html/veritabani.sql
   ```

3. Open the `onrender.com` URL and check the home page, a news URL, and `/admin/login.php`.

Later pushes to the connected branch redeploy the web service. The MySQL disk keeps the database.

### 5. Optional: custom domain and uploads

- **Custom domain:** web service → **Settings → Custom Domains**, then add the DNS record Render shows.
- **Uploads:** photos added in the admin panel are written under `wp-content/uploads`. The container disk is replaced on every deploy. To keep new uploads, add a disk on the web service mounted at `/var/www/html/wp-content/uploads`. An empty disk hides the images already in the image, so copy the existing `wp-content/uploads` tree onto the disk once before you rely on it. The map file `assets/js/turkey-map-data.js` is rewritten by the admin panel and is also replaced on the next deploy unless you persist that path the same way.

## Deploy on Railway

Railway builds the same `Dockerfile`. Add Railway's MySQL service in the same project, then reference its variables. The PHP code already understands `MYSQLHOST`, `MYSQLPORT`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQLDATABASE`, and `MYSQL_URL`.

### 1. Create the project

1. Sign in at [railway.com](https://railway.com).
2. **New Project → Deploy from GitHub repo**.
3. Choose `akartek-resmi/Terorsuz_Turkiye_Platformu` and the `main` branch.
4. Railway detects `Dockerfile` and starts a build. The first deploy can fail until the database variables exist. That is expected. Finish the database steps, then redeploy.

### 2. Add MySQL

1. On the project canvas, **+ New → Database → Add MySQL**.
2. Wait until the MySQL service is running.
3. Open the MySQL service → **Variables** and note the service name at the top of the canvas (often `MySQL`). You will use that name in the references below.

Railway creates `MYSQLHOST`, `MYSQLPORT`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQLDATABASE`, and `MYSQL_URL` on the database service. Import into that database (the name is usually `railway`).

### 3. Pass the database variables to the site

1. Open the web service (the GitHub repo service) → **Variables**.
2. **New Variable → Add Reference** and add each MySQL variable, keeping the same names: `MYSQLHOST`, `MYSQLPORT`, `MYSQLUSER`, `MYSQLPASSWORD`, `MYSQLDATABASE`, `MYSQL_URL`.

   Or paste this into **RAW Editor**, replacing `MySQL` with the service name from the canvas:

   ```text
   MYSQLHOST=${{MySQL.MYSQLHOST}}
   MYSQLPORT=${{MySQL.MYSQLPORT}}
   MYSQLUSER=${{MySQL.MYSQLUSER}}
   MYSQLPASSWORD=${{MySQL.MYSQLPASSWORD}}
   MYSQLDATABASE=${{MySQL.MYSQLDATABASE}}
   MYSQL_URL=${{MySQL.MYSQL_URL}}
   ```

3. Deploy the staged variable changes. Railway rebuilds the web service.

On the web service, use the private variables (`MYSQLHOST` and `MYSQL_URL`). Use the public host only in the import command on your computer.

### 4. Open a public URL

1. Web service → **Settings → Networking → Generate Domain**.
2. Railway routes that domain to the `PORT` the container listens on. Leave the target port on the value Railway shows after the deploy is healthy.
3. Open the generated URL.

### 5. Import the database

1. MySQL service → **Settings → Networking**.
2. Enable public networking (TCP proxy). Railway fills in `MYSQL_PUBLIC_URL` and a public host plus port.
3. From your machine, in this repo:

   ```bash
   mysql --host=PUBLIC_HOST --port=PUBLIC_PORT --user=MYSQLUSER --password=MYSQLPASSWORD MYSQLDATABASE < veritabani.sql
   ```

   Use the public host, public port, user, password, and database name from the MySQL service variables (`MYSQL_PUBLIC_URL` has the same values in one string).

4. Turn public networking off again when the import finishes. The site keeps using the private host.
5. Reload the site and sign in at `/admin/login.php`. Change the password at `/admin/password.php`.

Pushes to the connected branch redeploy the web service. MySQL data stays on the database service.

### 6. Optional: keep uploaded files

New admin and Instagram images are stored in `wp-content/uploads`, and the province map rewrite goes to `assets/js/turkey-map-data.js`. Both disappear on the next deploy because the container filesystem is ephemeral.

To keep uploads:

1. Web service → **Settings → Volumes → Add Volume**.
2. Mount path: `/var/www/html/wp-content/uploads`.
3. The volume starts empty and covers the images baked into the image. Copy the current `wp-content/uploads` contents into the volume once (Railway shell, or upload them again from the admin panel).

## After either deploy

- Sign in at `/admin/login.php` and set a new password at `/admin/password.php`.
- Confirm the home page, `/haberler/`, and one province page load data from MySQL.
- Each git push to the connected branch ships a new deploy.
