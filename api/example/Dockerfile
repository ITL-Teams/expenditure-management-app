FROM nginx

WORKDIR /home

COPY proxy.conf /etc/nginx/conf.d

RUN cd /etc/nginx/conf.d && rm default.conf && mv proxy.conf default.conf