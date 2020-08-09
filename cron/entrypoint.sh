#!/bin/sh
set -e
echo "$1" | crontab /cronjobs.sh && crond -f -L /dev/stdout -l $CRON_LOGLEVEL