#!/bin/bash

# Lolipop Upload Script
SERVER="ssh.lolipop.jp"
USER="deci.jp-trendcompany"
PORT="2222"
REMOTE_PATH="web/goldvision"

echo "========================================"
echo "Uploading Gold Vision Site to Lolipop"
echo "Target: http://goldvision.co.jp/"
echo "========================================"
echo ""
echo "1. Creating remote directory ($REMOTE_PATH)..."
ssh -p $PORT $USER@$SERVER "mkdir -p $REMOTE_PATH"

echo ""
echo "2. Uploading files..."
scp -P $PORT -r public_html/goldvision/* $USER@$SERVER:$REMOTE_PATH/

echo ""
echo "========================================"
echo "Upload Complete!"
echo "Please check: http://goldvision.co.jp/"
echo "========================================"
