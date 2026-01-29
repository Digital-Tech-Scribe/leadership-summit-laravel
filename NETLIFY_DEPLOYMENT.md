# Netlify Deployment Guide

This Laravel application is configured for deployment on Netlify.

## Prerequisites

1. **GitHub Repository**: Your code must be in a GitHub repository
2. **Netlify Account**: Sign up at [netlify.com](https://netlify.com)

## Deployment Steps

### 1. Connect Repository to Netlify

1. Log in to your Netlify dashboard
2. Click "New site from Git"
3. Choose GitHub and authorize Netlify
4. Select your repository

### 2. Configure Build Settings

Netlify will automatically detect the `netlify.toml` configuration file. The settings are:

- **Build command**: `./build.sh`
- **Publish directory**: `public`
- **Node version**: 18
- **PHP version**: 8.1

### 3. Environment Variables

Set these environment variables in Netlify dashboard (Site settings > Environment variables):

```bash
APP_NAME="Leadership Summit"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://your-site-name.netlify.app
DB_CONNECTION=sqlite
DB_DATABASE=/tmp/database.sqlite
MAIL_FROM_ADDRESS=info@leadershipsummit.com
MAIL_FROM_NAME="Leadership Summit"
```

**Important**: Generate a new `APP_KEY` by running `php artisan key:generate --show` locally and copy the result.

### 4. Custom Domain (Optional)

1. Go to Site settings > Domain management
2. Add your custom domain
3. Update `APP_URL` environment variable to match your domain

## Features Configured

✅ **Automatic builds** from GitHub pushes  
✅ **PHP 8.1** runtime  
✅ **Node.js 18** for asset compilation  
✅ **SQLite database** (file-based, suitable for small to medium sites)  
✅ **Laravel caching** (config, routes, views)  
✅ **Asset compilation** with Vite  
✅ **Database migrations** and seeding  
✅ **Storage linking**

## Database Considerations

This setup uses SQLite for simplicity on Netlify. For production applications with heavy database usage, consider:

- **Netlify + External Database**: Use services like PlanetScale, Supabase, or AWS RDS
- **Alternative Hosting**: Consider Laravel-specific hosting like Laravel Forge, Vapor, or traditional VPS

## Troubleshooting

### Build Fails

- Check the build logs in Netlify dashboard
- Ensure all environment variables are set
- Verify `build.sh` has execute permissions

### Database Issues

- SQLite database is recreated on each deployment
- For persistent data, use an external database service

### Asset Issues

- Ensure `npm run build` completes successfully
- Check that Vite configuration is correct

## Local Development

To test the build process locally:

```bash
# Make build script executable
chmod +x build.sh

# Run the build
./build.sh

# Test the application
php artisan serve
```

## Support

For deployment issues, check:

1. Netlify build logs
2. Laravel logs in `storage/logs/`
3. Browser developer console for frontend issues
