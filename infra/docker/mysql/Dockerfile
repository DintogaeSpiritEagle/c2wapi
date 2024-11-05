# Infra MYSQL Dockerfile
# Project: C2W API Application
# Maintaner: David H Tekwie <yamis.spiriteagle@gmail.com>
# Date: November 2024
# Caution: Speak to maintainer before executing these commands.
FROM mysql/mysql-server:8.0

# Updated maintainer label for YumiBung Project
LABEL maintainer="Spirit Eagle <yamis.spiriteagle@gmail.com>"

# Set DB TZ
ENV TZ=UTC

# Copy mysql conf to container
COPY ./infra/docker/mysql/my.cnf /etc/my.cnf    