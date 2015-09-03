FROM that0n3guy/baseimage-nginx-phpfpm
# https://registry.hub.docker.com/u/tutum/apache-php/dockerfile/

RUN rm -rf /app
RUN git clone https://github.com/oncalladvisors/mautic.git /app
RUN cd /app && git checkout Production

ADD ./.docker /build/

RUN rm /app/Dockerfile && mv /app/.docker /build/
RUN chmod +x /build/.docker/*/*.sh

RUN composer self-update

# Give web server permissions to access app folder
RUN chown -R www-data:www-data /app

# run our uploads setup script
#RUN bash /build/.docker/uploads/setup.sh

# run our nginx setup script
RUN bash /build/.docker/nginx/setup.sh

# run our queue-listener setup script
#RUN bash /build/.docker/queue-listener/setup.sh

RUN bash /build/.docker/after-boot-actions/setup.sh


# secure it by removing default keys.
RUN rm -rf /etc/service/sshd /etc/my_init.d/00_regen_ssh_host_keys.sh