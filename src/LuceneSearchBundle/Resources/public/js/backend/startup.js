pimcore.registerNS('pimcore.plugin.luceneSearch');

pimcore.plugin.luceneSearch = Class.create({

    isInitialized: false,

    getClassName: function () {
        return 'pimcore.plugin.luceneSearch';
    },

    initialize: function () {
        document.addEventListener(pimcore.events.preMenuBuild, this.preMenuBuild.bind(this));
    },

    uninstall: function () {
    },

    preMenuBuild: function (e) {
        // the event contains the existing menu
        let menu = e.detail.menu;

        let items = [{
            text: t("lucenesearch_settings"),
            iconCls: "lucenesearch_icon", // make sure your icon class exists
            priority: 10, // define the position where you menu should be shown. Core menu items will leave a gap of 10 custom menu items
            itemId: 'pimcorelucenesearchbundle_lucenesearch', // specify your custom itemId here
            handler: this.openSettings, // define a handler what should happen if you click on the menu item
        }];
        // the property name is used as id with the prefix pimcore_menu_ in the html markup e.g. pimcore_menu_dataprivacybundle
        menu.lucenesearchbundle = {
            label: t('lucenesearch_settings'), // set your label here, will be shown as tooltip
            iconCls: 'lucenesearch_icon', // set full icon name here
            priority: 72, // define the position where you menu should be shown. Core menu items will leave a gap of 10 custom main menu items
            items: items, //if your main menu has subitems please see Adding Custom Submenus To ExistingNavigation Items
            shadow: false,
            //handler: this.opendataprivacybundle, // defining a handler will override the standard "showSubMenu" functionality, use in combination with "noSubmenus"
            noSubmenus: false, // if there are no submenus set to true otherwise menu won't show up
            cls: "pimcore_navigation_flyout", // use pimcore_navigation_flyout if you have subitems
        };
    },

    openSettings: function () {
        try {
            pimcore.globalmanager.get('lucenesearch_settings').activate();
        } catch (e) {
            pimcore.globalmanager.add('lucenesearch_settings', new pimcore.plugin.luceneSearch.settings());
        }
    }

});

new pimcore.plugin.luceneSearch();