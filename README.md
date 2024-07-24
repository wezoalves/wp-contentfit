# Plugin: WP Content Fit

WP Content Fit is a plugin specifically developed for websites that produce content about fitness and well-being. With this plugin, you can create custom post types that perfectly fit the needs of a site focused on health, physical exercise, nutrition, and a healthy lifestyle.

### Custom Post Types Available:

- Tennis (/tenis)
- Store (/loja)
- Food (/alimento)

### Installation Example

##### Terminal
```bash
cd /path_wordpress/wp-content/plugins/;

git clone `git@github.com:wezoalves/wp-contentfit.git`
``` 
##### WordPress Admin
- Access WordPress Admin
- Navigate to Plugins / Installed Plugins
- Find in the List: **WezoAlves - Content Fit**
- Click on the Activate link

After Plugin Activation - the General menu will display:

- Stores *(/wp-admin/edit.php?post_type=loja)*
- Tennis *(/wp-admin/edit.php?post_type=tenis)*
- Food *(/wp-admin/edit.php?post_type=alimento)*