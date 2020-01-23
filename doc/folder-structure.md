# Plugin structure
```
plugins/extensions-for-pressbooks/                                              # → Plugin root
├── admin                                                                       # → Admin folder
│   ├── efpb-admin-settings.php                                                 # → Admin settings file php
│   ├── efpb-theme-customizations.php                                           # → Theme Customization file php
│   └── index.php                                                               # → Empty index file php                    
├── default                                                                     # → Default themes and settings folder
│   ├── efpb-default-settings.php                                               # → Default settings file php
│   ├── efpb-default-themes.php                                                 # → Default themes file php
│   └── index.php                                                               # → Empty index file php                       
├── doc                                                                         # → Doc folder
│   └── FOLDER-STRUCTURE.md                                                     # → Folder structure file md                    
├── groupByLanguage                                                             # → GroupByLanguage folder
│   └── efpb-groupByLanguage.php                                                # → GroupByLanguage file php                    
├── network-admin                                                               # → Network admin folder
│   └── efpb-network-admin.php                                                  # → Network admin file php
├── original-mark                                                               # → Original mark folder
│   ├── assets                                                                  # → Assets folder
│   │   └── scripts                                                             # → Scripts folder
│   │       └── original-mark-admin.js                                          # → Original mark admin file js
│   ├── efpb-original-mark.php                                                  # → Original mark file php
│   └── index.php                                                               # → Empty index file php                      
├── post-metabox-pb_is_based_on                                                 # → Post metabox folder  
│   └── efpb-post-metabox-pb_is_based_on.php                                    # → Post metabox file php
├── canonlcal                                                                   # → Canonical folder
│   ├── efpb-canonical.php                                                      # → Canonical file php
│   └── index.php                                                               # → Empty index file php
├── wp-assets                                                                   # → Wp assets folder
│   ├── banner-772x250.png                                                      # → Banner file png
│   ├── banner-1544x500-rtl.png                                                 # → Banner file png
│   ├── banner-1544x500.png                                                     # → Banner file png
│   ├── icon-128x128.png                                                        # → Icon file png
│   ├── icon-256x256.png                                                        # → Icon file png
│   ├── screenshot-1.png                                                        # → Screenshot file png  
│   └── screenshot-2.png                                                        # → Screenshot file png                    
├── .editorconfig                                                               # →                     
├── .gitattributes                                                              # →                     
├── .gitignore                                                                  # →                     
├── extensions-for-pressbooks.php                                               # → Main function of plugin file php                    
├── index.php                                                                   # → Empty index file php                    
├── LICENSE.md                                                                  # → License file md                    
├── LICENSE.txt                                                                 # → License file txt                    
├── README.md                                                                   # → Readme file md                    
└── readme.txt                                                                  # → Readme file txt                    
