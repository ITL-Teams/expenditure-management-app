FROM node:current-slim

RUN mkdir /home/app
WORKDIR /home/app

COPY ["package.json", "package-lock.json", "/home/app/"]

RUN cd /home/app && npm ci
CMD ["npm", "run", "docker:container:dev"]