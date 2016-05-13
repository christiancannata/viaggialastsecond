#!/usr/bin/env bash
cap production deploy
cap production ops:put_env_components
ssh -i "meritocracy_server.pem" ubuntu@ec2-52-16-133-1.eu-west-1.compute.amazonaws.com << EOF
cd /var/www/meritocracy-app/current
sudo chmod -R 777 storage
EOF
echo "Deployed"