Advanced access control plugin for CollectiveAccess
=================================

*DESCRIPTION:*
By default in CollectiveAccess, the "edit" permission is not very granular.
If you give a user the permission "edit object", he can edit every object in the installation.

This plugin adds an extra layer on top of that standard permission, allowing you to decide per access role whether accounts in that role are allowed to edit all items, or only the items they created themselves.
This gives you the possibility to create a user group that is only allowed to input data into your CollectiveAccess installation, but not mess with the input of other people.

*INSTALL:*
* Make sure the plugin folder is named "advAccessControl".
* Place this folder in app/plugins, so that this file can be found: app/plugins/advAccessControl/advAccessControlPlugin.php

*USAGE:*
* Go to Manage > Access Control > Access roles
* Edit the roles which should be able to edit all CollectiveAccess items of a specific primary type, not only their own.
* Give them the permission "Edit all <primary type>", e.g. "Edit all objects".
* If you want to give permission to edit all primary types, just give the role the permission "Edit all content".

Note that if users didn't have access to edit a specific primary type prior to installing this plugin, this plugin will not grant them access. It is just a layer on top.

*CREDITS:*

This CollectiveAccess plugin was written by Sven Decabooter of Pure Sign (http://puresign.be).
This plugin was sponsored by Colibreo (http://colibreo.com) - a SaaS collection management & public website solution.