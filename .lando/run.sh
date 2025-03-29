if [ ! -d "./wp-admin" ]; then
	wp core download
fi

if ! $(wp core is-installed); then
	wp core install --url="http://$LANDO_APP_NAME.lndo.site" --title="WP Starter" --admin_user="admin" --admin_password="password" --admin_email="admin@$LANDO_APP_NAME.lndo.site" --skip-email
fi