# Production Deployment Guide

This guide explains how to manually deploy the application to your VPS after the GitHub Action CI has successfully pushed the Docker image to Docker Hub.

## Prerequisites

1.  **VPS** with Docker and Docker Compose installed.
2.  **Docker Hub Credentials** stored in GitHub Secrets:
    - Go to your repo on GitHub: **Settings > Secrets and variables > Actions**.
    - Click **New repository secret**.
    - Add `DOCKER_USERNAME` (your Docker Hub username).
    - Add `DOCKER_PASSWORD` (your Docker Hub personal access token or password).
3.  **Environment Variables**: A `.env.prod` file on your VPS with production values.

## Deployment Steps

### 1. SSH into your VPS
```bash
ssh your-user@your-vps-ip
```

### 2. Prepare the Deployment Directory
Create a folder for the project if you haven't already:
```bash
mkdir -p citizen-complaint
cd citizen-complaint
```

### 3. Setup Production Environment (`.env`)
Create a `.env` file on your VPS using the template below. Replace the values with your actual production credentials:

```env
# Database
DB_CONNECTION=mysql
DB_HOST=your_db_host
DB_PORT=3306
DB_DATABASE=citizen_complaint
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
DB_COLLATION=utf8mb4_unicode_ci

# Redis
REDIS_HOST=your_redis_host
REDIS_PORT=6379

# S3 Storage
AWS_ACCESS_KEY_ID=your_access_key
AWS_SECRET_ACCESS_KEY=your_secret_key
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=citizen-complaint
AWS_URL=https://your-bucket-url.com
AWS_ENDPOINT=https://your-s3-endpoint.com

# Email (SMTP)
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_smtp_user
MAIL_PASSWORD=your_smtp_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="E-Lapor Citizen Complaint"

# Docker Hub
DOCKER_USERNAME=your_docker_hub_username
```

> [!NOTE]
> This setup supports **external Database, Redis, S3, and Email (SMTP)**. Ensure all credentials in `.env` are correct.

### 4. Pull and Start the Application
```bash
docker compose -f docker-compose.prod.yml pull
docker compose -f docker-compose.prod.yml up -d
```

### 5. Setup External Nginx Load Balancer
Install Nginx and Certbot on your VPS host:

```bash
sudo apt update
sudo apt install nginx certbot python3-certbot-nginx -y
```

#### Obtain SSL Certificate
Run Certbot to obtain your certificates:
```bash
sudo certbot --nginx -d complaint.yourdomain.com
```

#### External Nginx Configuration Example
After obtaining the certificates, ensure your file at `/etc/nginx/sites-available/citizen-complaint` looks like this:

```nginx
upstream citizen_complaint_app {
    # Session Awareness: use ip_hash to ensure users stay on the same server
    # although Laravel handles this via Redis, ip_hash provides extra stability.
    ip_hash;
    
    # List your app instances here (Round Robin is default)
    server 127.0.0.1:8000;
    # server 127.0.0.1:8001; # Add more nodes here for load balancing
}

server {
    listen 80;
    server_name complaint.yourdomain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name complaint.yourdomain.com;

    ssl_certificate /etc/letsencrypt/live/complaint.yourdomain.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/complaint.yourdomain.com/privkey.pem;

    location / {
        proxy_pass http://citizen_complaint_app;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
        
        # Session awareness/timeout settings
        proxy_read_timeout 300s;
        proxy_connect_timeout 75s;
    }
}
```

Enable the site and restart Nginx:
```bash
sudo ln -s /etc/nginx/sites-available/citizen-complaint /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

#### SSL Auto-Renewal
Certbot automatically sets up a systemd timer or cron job to renew your certificates. You can verify it by running:
```bash
sudo certbot renew --dry-run
```
If this command succeeds, your certificates will renew automatically before they expire.

### 6. Run Database Migrations
Before running migrations, ensure your database exists. Run this command (it will automatically use the values from your `.env` file):

> [!IMPORTANT]
> If your database is on the same VPS, use `127.0.0.1` instead of `localhost` in your `.env` to avoid "No such file or directory" socket errors.

```bash
# Create database if it doesn't exist (using .env values already in container)
docker exec -it citizen-complaint-app php -r "
    \$host = getenv('DB_HOST');
    \$user = getenv('DB_USERNAME');
    \$pass = getenv('DB_PASSWORD');
    \$db   = getenv('DB_DATABASE');
    try {
        \$pdo = new PDO(\"mysql:host=\$host\", \$user, \$pass);
        \$pdo->exec(\"CREATE DATABASE IF NOT EXISTS \`\$db\` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci\");
        echo \"Database '\$db' verified/created.\\n\";
    } catch (PDOException \$e) {
        die(\"DB Error: \" . \$e->getMessage() . \"\\n\");
    }
"
```

Now, execute the migrations:
```bash
docker exec -it citizen-complaint-app php artisan migrate --force
```

### 7. Post-Deployment Checks
- Verify if the application is accessible on your domain.
- Check logs: `docker compose -f docker-compose.prod.yml logs -f app`

## Automatic Deployment (Next Level)
To automate this "SSH & Pull" process, you can extend the CI workflow with an `ssh-action` to run these commands automatically whenever a push to `main` completes.
