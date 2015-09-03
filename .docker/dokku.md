# Dokku Documentation
see oncalladvisors repo for this doc

## Before pushing THIS staging/production app, you need to setup some data volumes/containers:
These are the commands I used as dokku admin:

Create the app(s):
```
dokku create sms
```

Setup the docker data volume for th uploads folder
```
mkdir -p /data/appdata/connect/
dokku volume:create connect_data /data/appdata/connect/vendor:/app/vendor /data/appdata/connect/storage/app:/app/storage/app
dokku volume:link connect connect_data
```

Set the envirsonment variable for the server types (staging or production)
```
see lastpass
```

Set the domains for the production (after your first push)
```
dokku domains:set sms sms.oncalladvisors.com
cat ssl-bundle.crt | dokku ssl:certificate sms
cat oca.com.key | dokku ssl:key sms
```

Also, see the dokku-alt docs on setting the ssl certificate.

## For pushing theme changes to git
```
git pull origin AutoCmsSave
git checkout master
git merge AutoCmsSave
```

make changes changes and commit them to master.

Merge the theme changes to AutoCmsSave
```
git push origin master
git push prod master
```

Dokku stores the mongodb in /home/dokku/.mongodb... I relocated it with:

```
docker stop mongodb_single_container
mkdir -p /data/dokku/.mongodb
chown dokku:dokku /data/dokku/.mongodb
mv /home/dokku/.mongodb /data/dokku/
ln -s /data/dokku/.mongodb /home/dokku/.mongodb
docker start mongodb_single_container
```

#Important#
Need to add the client_max_body_size to the dokku nginx.conf.d folder (ie ~dokku/connect/nginx.conf.d/*.conf) config
