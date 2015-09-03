#!/bin/sh
#cp -a /build/queue-listener/init.sh /etc/my_init.d/00_configure_queue_listener.sh
#chmod +x /etc/my_init.d/00_configure_queue_listener.sh

# Configure queue_listener to start as a service
mkdir /etc/service/queue-listener
cp -a /build/.docker/queue-listener/runit.sh /etc/service/queue-listener/run
chmod +x /etc/service/queue-listener/run
