# Add New CPT

**Create Classes.php in dirs**

- **src/Model/{CptName}.php**
```php
<?php
namespace Review\Model;

final class Example
{
    public string $id;
    public string $name;
    public string $type = "text";
    public $value = null;
    public array $options = [];

    public function __construct(
        string $id,
        string $type,
        string $name,
        $value = null,
        $options = [])
    {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->options = $options;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }
}
```
- **src/WordPress/CustomPostType/{CptName}.php**
```php
<?php
namespace Review\WordPress\CustomPostType;

use Review\WordPress\Fields\Example as ExampleFields;

final class Example
{
    private static string $key = "slug_custom_post_type";

    public static function getKey()
    {
        return self::$key;
    }
    public static function init()
    {
        $labels = array(
            'name' => '{Name Plural}',
            'singular_name' => '{Name Singular}',
            'menu_name' => '{Name Plural}',
            'name_admin_bar' => '{Name Singular}',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New {Name Singular}',
            'new_item' => 'New {Name Singular}',
            'edit_item' => 'Edit {Name Singular}',
            'view_item' => 'View {Name Singular}',
            'all_items' => 'All {Name Plural}',
            'search_items' => 'Search {Name Plural}',
            'not_found' => 'Not found {Name Singular}',
            'not_found_in_trash' => 'Not found {Name Singular} in trash.'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-carrot',
            'supports' => array('title', 'editor', 'thumbnail','custom-fields'),
            'show_in_rest' => true
        );

        register_post_type(self::$key, $args);

        add_action('add_meta_boxes', [self::class, 'add_meta_boxes']);
        add_action('save_post', [ExampleFields::class, 'saveMeta']);
        add_action('rest_api_init', [new \Review\Api\Food(), 'RestFoodApiInit']);
    }

    public static function add_meta_boxes()
    {
        add_meta_box(
            self::$key . '_meta_box',
            '{Name Box In Admin}',
            [ExampleFields::class, 'showMetaBox'],
            self::$key,
            'advanced',
            'default'
        );
    }
}
```
- **src/WordPress/Fields/{CptName}.php**
```php
<?php
namespace Review\WordPress\Fields;

use Review\Model\Field;
use Review\WordPress\Fields;

final class Example extends Fields
{
    public static function fields()
    {
        $key = \Review\WordPress\CustomPostType\Example::getKey();

        $types = [
            ["id" => "ID_ONE_FIELD", "title" => "TITLE TYPE ONE"],
            ["id" => "ID_TWO_FIELD", "title" => "TITLE TYPE TWO"]
        ];

        $fields = [
            new Field("{$key}_type", "select", "Type Od Data", "", null, "TYPE", $types),
            new Field("{$key}_description", "textarea", "Description", "", null, "DETAIL", []),
            new Field("{$key}_name", "text", "Name Data", "", null, "DETAIL", []),
            new Field("{$key}_score", "range", "Score", "", null, "DETAIL", [0, 10, 0.1]),
        ];

        return $fields;
    }

    public static function showMetaBox($post)
    {
        parent::show_meta_box($post, self::fields());
    }

    public static function saveMeta($post_id)
    {
        parent::save_meta($post_id, self::fields());
    }

    public static function registerCustomFields()
    {
        parent::register_custom_fields(self::fields());
    }
}

```
- **src/Repository/{CptName}.php**
```php
<?php
namespace Review\Repository;

use \Review\Model\Example as ExampleModel;

final class Example
{
    public function getById($post_id)
    {
        $post = get_post($post_id);

        if (! $post) {
            return null;
        }

        $options = [
            (new \Review\Model\SimpleType("ID_ONE", "Name One")),
            (new \Review\Model\SimpleType("ID_TWO", "Name Two"))
        ];
        $data = (new ExampleModel($post->ID, "TYPE_C", "NAME", "VALUE", $options));
        return $data;
    }

    public function getAll($per_page = 10, $page = 0, $search_term = null)
    {

        $args = array(
            'post_type' => \Review\WordPress\CustomPostType\Example::getKey(),
            'posts_per_page' => $per_page,
            'paged' => $page,
            's' => $search_term
        );

        $custom_types_query = new \WP_Query($args);
        $itemsArray = [];
        if ($custom_types_query->have_posts()) {

            $options = [
                (new \Review\Model\SimpleType("ID_ONE", "Name One")),
                (new \Review\Model\SimpleType("ID_TWO", "Name Two"))
            ];

            while ($custom_types_query->have_posts()) {
                $custom_types_query->the_post();

                $post = get_post(get_the_ID());
                $data = (new ExampleModel($post->ID, "TYPE_C", "NAME", "VALUE", $options));

                $itemsArray[] = $data;
            }
            wp_reset_postdata();
        }
        return $itemsArray;
    }
}
```