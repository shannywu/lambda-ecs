import boto3
import os
import sys

def handler(event, context):
    for record in event['Records']:
        s3_bucket = record['s3']['bucket']['name']
        s3_object_key = record['s3']['object']['key']
        s3_region = record['awsRegion']


    ecs = boto3.client('ecs')

    response = ecs.run_task(
        cluster='test-cluster',
        taskDefinition='test-task-def',
        overrides={
            'containerOverrides': [
                {
                    'name': 'test',
                    'environment': [
                        {
                            'name': 'S3_BUCKET',
                            'value': s3_bucket
                        },
                        {
                            'name': 'S3_REGION',
                            'value': s3_region
                        },
                        {
                            'name': 'S3_OBJECT_KEY',
                            'value': s3_object_key
                        }
                    ],
                },
            ],
        },
        count=1,
        launchType='FARGATE'
    )