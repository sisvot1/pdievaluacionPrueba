#
# $Id: upgrade_21_to_211.sql,v 1.1.2.1 2007/11/15 02:13:58 ajdonnison Exp $
# 
# DO NOT USE THIS SCRIPT DIRECTLY - USE THE INSTALLER INSTEAD.
#
# All entries must be date stamped in the correct format.
#
#20071113
# Remove the NOT NULL clause from company_description to avoid issues on win plaforms
ALTER TABLE `companies` MODIFY `company_description` text;
