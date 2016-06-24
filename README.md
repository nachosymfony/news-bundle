TWIG Function:
    nacholibre_news_post_link(post) - генерира адрес до новина

config.yml
    nacholibre_news:
        urls:
            type: 'date_prefixed' #available: date_prefixed, slug_id
            prefix: ''
        editor:
            name: 'ckeditor'
            elfinder_integration: true

routing.yml
    #this is for the admin
    nacholibre.admin.news:
        resource: "@nacholibreNewsBundle/Controller/Admin/NewsController.php"
        type:     annotation
        prefix:   /vpanel/news

    #this is for the front end
    nacholibre.news:
        resource: .
        type: extra

required ivory_ck_editor and fm_elfinder, here are example configs:
    fm_elfinder:
        assets_path: assets/vendor/finderbundle
        instances:
            default:
                locale: %locale% # defaults to current request locale
                editor: ckeditor # other options are tinymce, tinymce4, fm_tinymce, form, simple, custom
                #editor_template: custom template for your editor # default null
                #path_prefix: / # for setting custom assets path prefix, useful for non vhost configurations, i.e. http://127.0.0.1/mysite/
                #assets_path: /asd/ # for setting custom assets path prefix, useful for non vhost configurations, i.e. http://127.0.0.1/mysite/
                #fullscreen: true|false # default is true, applies to simple and ckeditor editors
                #theme: smoothness # jquery theme, default is 'smoothness'
                include_assets: true # disable if you want to manage loading of javascript and css assets manually
                #visible_mime_types: ['image/png', 'image/jpg', 'image/jpeg'] # only show these mime types, defaults to show all
                connector:
                    #debug: true|false # defaults to false
                    roots:       # at least one root must be defined, defines root filemanager directories
                        uploads:
                            #show_hidden: true|false # defaults to false, hides dotfiles
                            driver: LocalFileSystem
                            path: uploads
                            upload_allow: ['image/png', 'image/jpg', 'image/jpeg']
                            upload_deny: ['all']
                            upload_max_size: 10M # also file upload sizes restricted in php.ini
                            #attributes: example of setting attributes permission
                            #    - { pattern: '/(.*?)/', read: true, write: false, locked: true }

    ivory_ck_editor:
        configs:
            default:
                toolbar: standard
                height: 500
                filebrowserBrowseRoute: elfinder
                filebrowserBrowseRouteParameters: []

AppKernel.php
    //news
    $bundles[] = new nacholibre\NewsBundle\nacholibreNewsBundle();

    //ivory editor and file browser
    $bundles[] = new Ivory\CKEditorBundle\IvoryCKEditorBundle();
    $bundles[] = new FM\ElfinderBundle\FMElfinderBundle();

    //vich uploader for news main photo thumb
    $bundles[] = new Vich\UploaderBundle\VichUploaderBundle();
