# Plugin structure
```
plugins/extensions-for-pressbooks/                                              # → Plugin root
├── default-theme/                                                              # → Default theme folder                    
│   └── default-theme.php                                                       # → Php default theme functions
├── doc/                                                                        # → Default doc folder
│   └── folder-structure.php                                                    # → Plugin folder structure
│   └── user-manual.php                                                         # → Plugin user manual
├── network-admin
│   └── efp-network-admin.php                                                   # → Network admin multisite settings
├── original-mark/                                                              # → Original mark folder
│   └── assets/                                                                 # → Assets folder
│       └── original-mark.php                                                   # → Original mark php
│       └── scripts/                                                            # → Script folder
│           └── original-mark-admin.js                                          # → Original mark script
├── post-metabox-pb_is_based_on                                                 
│   └── post-metabox-pb_is_based_on.php                                         # → Metabox in post-edit page
├── wp-assets/                                                                  # → Images folder
│   └── all-banner.png                                                          # → Image
└── extensions-for-pressbooks.php                                               # → Customise style of the theme php
