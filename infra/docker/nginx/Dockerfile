# Infra MYSQL Dockerfile
# Project: C2W API Application
# Maintaner: David H Tekwie <yamis.spiriteagle@gmail.com>
# Date: November 2024
# Caution: Speak to maintainer before executing these commands.
FROM node:16-alpine as node
FROM nginx:1.20-alpine

# Updated maintainer label for YumiBung Project
LABEL maintainer="Spirit Eagle <yamis.spiriteagle@gmail.com>"

# Initialize ash shell
SHELL ["/bin/ash", "-oeux", "pipefail", "-c"]

# Set TZ
ENV TZ=UTC

# Add sh gcc compiler deps
# RUN apt update && \
#  apt add --update --no-cache --virtual=.build-dependencies g++

# Copy node command to container
COPY --from=node /usr/local/bin /usr/local/bin

# Copy npm command to container
COPY --from=node /usr/local/lib /usr/local/lib

# Copy yarn command to container
COPY --from=node /opt /opt

# Copy nginx config to container
COPY ./infra/docker/nginx/*.conf /etc/nginx/conf.d/

WORKDIR /work/app