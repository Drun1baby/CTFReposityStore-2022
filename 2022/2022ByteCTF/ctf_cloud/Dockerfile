FROM node:13

# install sqlite
RUN sed -i 's/deb.debian.org/mirrors.aliyun.com/g' /etc/apt/sources.list && \
    sed -i '/security/d' /etc/apt/sources.list && \
    apt-get update 
RUN apt-get install libsqlite3-dev sqlite3 -y

# npm install
COPY ./src /usr/local/app
WORKDIR /usr/local/app
RUN npm i --registry=https://registry.npm.taobao.org
RUN npm install npm@latest -g

# copy other files
COPY ./db.sql /db.sql
COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD /start.sh
