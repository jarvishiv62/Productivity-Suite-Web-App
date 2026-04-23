# Deploy DailyDrive on Render

This guide will help you deploy your DailyDrive application on Render.com.

## 🚀 Quick Deployment Steps

### 1. Prepare Your Repository

1. **Push your code to GitHub:**
   ```bash
   git add .
   git commit -m "Ready for Render deployment"
   git push origin main
   ```

2. **Create a Render account:**
   - Visit [render.com](https://render.com)
   - Sign up with your GitHub account

### 2. Create Services on Render

#### Web Service
1. Click **New** → **Web Service**
2. Connect your GitHub repository
3. Configure the service:
   - **Name**: `dailydrive`
   - **Environment**: `PHP`
   - **Plan**: `Starter` (free tier available)
   - **Build Command**: 
     ```bash
     composer install --no-dev --optimize-autoloader
     php artisan key:generate
     php artisan storage:link
     php artisan config:cache
     php artisan route:cache
     php artisan view:cache
     ```
   - **Start Command**:
     ```bash
     php artisan migrate --force
     php artisan optimize
     apache2-foreground
     ```
   - **Health Check Path**: `/health`

#### Database Service
1. Click **New** → **PostgreSQL** (or MySQL)
2. Configure:
   - **Name**: `dailydrive-db`
   - **Plan**: `Free`
   - **Database Name**: `dailydrive`
   - **User**: `dailydrive`

#### Redis Service
1. Click **New** → **Redis**
2. Configure:
   - **Name**: `dailydrive-redis`
   - **Plan**: `Free`

### 3. Configure Environment Variables

Add these environment variables to your web service:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.onrender.com

# Database (Render will auto-populate these)
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=dailydrive
DB_USERNAME=your-db-username
DB_PASSWORD=your-db-password

# Redis (Render will auto-populate these)
REDIS_HOST=your-redis-host
REDIS_PORT=6379
REDIS_PASSWORD=your-redis-password

# Cache and Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Mail (for daily quotes)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-app-name.onrender.com
MAIL_FROM_NAME="DailyDrive"

# Application
APP_NAME="DailyDrive"
APP_TIMEZONE=UTC
```

### 4. Add Persistent Disk

1. Go to your web service settings
2. Click **Add Disk**
3. Configure:
   - **Name**: `dailydrive-storage`
   - **Mount Path**: `/var/www/html/storage`
   - **Size**: `1 GB`

### 5. Set Up Cron Job (Scheduler)

1. Click **New** → **Cron Job**
2. Configure:
   - **Name**: `dailydrive-scheduler`
   - **Schedule**: `*/10 * * * *` (every 10 minutes)
   - **Command**: `php /var/www/html/artisan schedule:run`
   - **Service**: Select your web service

### 6. Deploy!

Click **Create Web Service** and Render will automatically:
1. Build your application
2. Run migrations
3. Start the server
4. Set up the health check

## 🔧 Post-Deployment Setup

### 1. Test Your Application
- Visit your app URL: `https://your-app-name.onrender.com`
- Register a new account
- Create some tasks and goals
- Test all features

### 2. Configure Email (Optional)
If you want daily quote emails:
1. Set up a Gmail app password
2. Update mail environment variables
3. Test with: `php artisan quotes:send`

### 3. Enable HTTPS
Render automatically provides HTTPS for all services.

### 4. Custom Domain (Optional)
1. Go to your service settings
2. Click **Custom Domain**
3. Add your domain name
4. Update DNS records as instructed

## 🛠️ Troubleshooting

### Common Issues

1. **Build Fails:**
   - Check build logs
   - Ensure `composer.json` is valid
   - Verify PHP version compatibility

2. **Database Connection:**
   - Check database service is running
   - Verify environment variables
   - Test connection manually

3. **Storage Issues:**
   - Ensure persistent disk is mounted
   - Check permissions on storage directory
   - Run `php artisan storage:link`

4. **Scheduler Not Working:**
   - Verify cron job is active
   - Check cron job logs
   - Test manually: `php artisan schedule:run`

### Useful Commands

```bash
# Access your service logs
render logs dailydrive

# Access database
render psql dailydrive-db

# Restart service
render restart dailydrive

# Redeploy
render deploy dailydrive
```

## 📊 Monitoring

Render provides built-in monitoring:
- **Health Checks**: Automatic health monitoring
- **Metrics**: CPU, memory, and network usage
- **Logs**: Real-time log streaming
- **Alerts**: Email notifications for issues

## 🔄 Continuous Deployment

Every push to your main branch will trigger an automatic deployment. To control this:
- Go to service settings
- Toggle **Auto-deploy**
- Or use branches for staging

## 💡 Pro Tips

1. **Use the Free Tier**: Render's free tier is generous for small apps
2. **Monitor Usage**: Keep an eye on database and Redis usage
3. **Backups**: Enable automatic database backups
4. **Performance**: Use Redis for caching to reduce database load
5. **Security**: Keep your environment variables secret

## 🆘 Support

If you run into issues:
1. Check Render's [documentation](https://render.com/docs)
2. Review your service logs
3. Test locally with the same environment variables
4. Join Render's Discord community for help

Your DailyDrive app should now be live and accessible to the world! 🎉
