FROM php-7.1-runner

ARG TEST

COPY $TRANSFORMER /srv/docker-test

ENTRYPOINT /srv/docker-test/test_lambda_ecs.php --s3-bucket $S3_BUCKET --s3-region $S3_REGION --s3-object-key $S3_OBJECT_KEY