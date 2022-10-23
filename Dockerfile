FROM trafex/php-nginx
WORKDIR /var/www/html


COPY --chown=nobody ./code /var/www/html
RUN chown -R nobody.nobody /var/www/html

EXPOSE 8080
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]