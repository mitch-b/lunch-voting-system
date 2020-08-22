FROM alpine
RUN apk add --no-cache curl

# set cron timezone
ENV TZ="America/Chicago"
RUN apk add tzdata
RUN cp /usr/share/zoneinfo/$TZ /etc/localtime
RUN echo $TZ > /etc/timezone

# copy cron data into container
COPY entrypoint.sh /entrypoint.sh
COPY update.cron /cronjobs.sh

WORKDIR /app
RUN touch cron-out.txt

ENV CRON_LOGLEVEL 7

ENTRYPOINT ["/entrypoint.sh"]
