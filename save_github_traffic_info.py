#!/usr/bin/env python

from datetime import datetime
from glob import glob
import requests
import json
import os

#settings
USER_AGENT = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2227.0 Safari/537.36'

with open('tokens/GITHUB_USERNAME', 'r') as file:
    GITHUB_USERNAME = file.read().rstrip()

with open('tokens/GITHUB_PASSWORD', 'r') as file:
    GITHUB_PASSWORD = file.read().rstrip()

with open('tokens/GITHUB_ACCESS_TOKEN', 'r') as file:
    GITHUB_ACCESS_TOKEN = file.read().rstrip()

#download view and clone counts
for repo_config_filename in glob('repo/*.json'):
    with open(repo_config_filename, 'r') as file:
        config = json.load(file)

    owner = 'KarrLab'
    repo = config['id']

    #views
    url = 'https://api.github.com/repos/{}/{}/traffic/views?per=day'.format(owner, repo)

    r = requests.get(url,
        headers={
            'Authorization': 'token {}'.format(GITHUB_ACCESS_TOKEN),
            'accept': 'application/vnd.github.spiderman-preview',
            'user-agent': USER_AGENT,
        },
    )

    response = r.json()
    if r.status_code < 200 or r.status_code >= 300:
        raise Exception(response)

    if 'views' in response and len(response['views']) > 0:
        views = response['views'][-1]['count']
        unique_views = response['views'][-1]['uniques']
    else:
        views = 0
        unique_views = 0

    #clones
    url = 'https://api.github.com/repos/{}/{}/traffic/clones?per=day'.format(owner, repo)

    r = requests.get(url,
        headers={
            'Authorization': 'token {}'.format(GITHUB_ACCESS_TOKEN),
            'accept': 'application/vnd.github.spiderman-preview',
            'user-agent': USER_AGENT,
        },
    )

    response = r.json()
    if r.status_code < 200 or r.status_code >= 300:
        raise Exception(response)

    if 'clones' in response and len(response['clones']) > 0:
        clones = response['clones'][-1]['count']
        unique_clones = response['clones'][-1]['uniques']
    else:
        clones = 0
        unique_clones = 0

    #log results
    filename = os.path.join('repo', '{}.stats.tsv'.format(repo))

    if not os.path.isfile(filename):
        with open(filename, 'a') as file:
            file.write('{}\t{}\t{}\t{}\t{}\n'.format('Date', 'Views', 'Unique views', 'Clones', 'Unique clones'))

    with open(filename, 'a') as file:
        file.write('{}\t{}\t{}\t{}\t{}\n'.format(datetime.now().strftime('%Y-%m-%d'), views, unique_views, clones, unique_clones))

print('Successfully downloaded lastest traffic data')
