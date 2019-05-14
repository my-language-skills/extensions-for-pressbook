# Theme structure
```
plugins/extensions-for-pressbooks/                                              # → Plugin root
├── default-theme/                                                              # → Default theme folder                    
│   └── default-theme.php                                                       # → Php default theme functions
├── doc/                                                                        # → Default doc folder
├── media/                                                                      # → Default doc folder
│   └── automatically-set-the-wordpress-image-title-alt-text-other-meta.php     # → Automatically set the wordpress image title alt text other meta
├── original-mark/                                                              # → Original mark folder
│   └── assets/                                                                 # → Assets folder
│       └── original-mark.php                                                   # → Original mark php
│       └── scripts/                                                            # → Script folder
│           └── original-mark-admin.js                                          # → Original mark script
├── vendor/                                                                     # → Vendor folder
│   └── plugin-update-checker/                                                  # → Update plugin with Admin panel (gitub)                                      
├── wp-assets/                                                                  # → Images folder
│   └── all-banner.png                                                          # → Image
└── extensions-for-pressbooks.php                                               # → Customise style of the theme php
