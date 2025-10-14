#!/bin/bash

echo "Starting Laravel Queue Worker..."
echo "This will process email notifications in the background"
echo "Press Ctrl+C to stop the worker"
echo

cd /path/to/your/project

php artisan queue:work --daemon --sleep=3 --tries=3 --max-time=3600
