# UM Archive of Deleted Users

User deletion from the user account page will change the user to a new UM role "Archived" and also updating the "account_status" to "archived".

Login is blocked for users with the "Archived" role.

Display of user profiles for "Archived" users are prohibited for all users except for Administrators with a note by the end of the profile page: "This user account is archived". 

Email is being sent when user is "deleting" the account and also later when the Administrator is physically deleting the account, so the e-mail text must be updated for the new two-step deletion of an account.

# Installation

Create a new UM role "Archived" (um_archived).

The "Archived" users must be removed from Member Directories display by user setting.

Add the php source code to your child-theme functions.php file
or use the Code Snippet plugin: https://wordpress.org/plugins/code-snippets/
