FROM alpine
RUN apk add --no-cache curl
COPY entrypoint.sh /entrypoint.sh
COPY update.cron /cronjobs.sh
ENV CRON_LOGLEVEL 7
WORKDIR /app
RUN touch cron-out.txt
ENTRYPOINT ["/entrypoint.sh"]
