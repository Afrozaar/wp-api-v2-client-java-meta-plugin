#!/usr/bin/env bash

rm ../wp-api-v2-client-java-meta-plugin.zip

zip -r ../wp-api-v2-client-java-meta-plugin.zip . --exclude .\* --exclude dist.sh
