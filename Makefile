######################################################
# Start edit here
VENDOR:=DerModPro
MODULE:=BasePrice
ARCHIVE_COLLECTION:=app skin modman
# End edit here
######################################################

######################################################
# Build script variables
MODULE_KEY:=$(VENDOR)_$(MODULE)
DATE:=$(shell date +%s)
VERSION:=$(shell grep "<version>" app/code/community/$(VENDOR)/$(MODULE)/etc/config.xml | sed -e :a -e 's/<[^>]*>//g;/</N;//ba;s/ //g')

#Paths and zip-file
MODULE_PATH:=$(shell pwd)
TMPPATH:=/tmp/$(MODULE).$(DATE)
ZIPNAME:=$(MODULE)_$(VERSION).zip
ZIPFILE:=/tmp/$(ZIPNAME)

# Doc folders
DOCPATH:=doc
DOC_PUBLIC_PATH:=$(DOCPATH)/$(MODULE_KEY)
DOC_INTERN_PATH:=$(DOCPATH)/Intern
DOC_SOURCE_PATH:=$(DOCPATH)/src
######################################################

all: clean version doc zip

doc: $(DOC_PUBLIC_PATH)/ChangeLog.pdf $(DOC_PUBLIC_PATH)/Specification.pdf $(DOC_INTERN_PATH)/KnownIssues.pdf

$(DOC_PUBLIC_PATH)/ChangeLog.pdf: $(DOC_SOURCE_PATH)/ChangeLog.rst $(DOC_SOURCE_PATH)/netresearch.style
		rst2pdf -b 1 -o $(DOC_PUBLIC_PATH)/ChangeLog.pdf -s $(DOC_SOURCE_PATH)/netresearch.style $(DOC_SOURCE_PATH)/ChangeLog.rst --real-footnotes
		
$(DOC_PUBLIC_PATH)/Specification.pdf: $(DOC_SOURCE_PATH)/Specification.rst $(DOC_SOURCE_PATH)/netresearch.style
		rst2pdf -b 1 -o $(DOC_PUBLIC_PATH)/Specification.pdf -s $(DOC_SOURCE_PATH)/netresearch.style $(DOC_SOURCE_PATH)/Specification.rst --real-footnotes
		
$(DOC_INTERN_PATH)/KnownIssues.pdf: $(DOC_SOURCE_PATH)/KnownIssues.rst $(DOC_SOURCE_PATH)/netresearch.style
		rst2pdf -b 1 -o $(DOC_INTERN_PATH)/KnownIssues.pdf -s $(DOC_SOURCE_PATH)/netresearch.style $(DOC_SOURCE_PATH)/KnownIssues.rst --real-footnotes

$(DOC_INTERN_PATH)/KnownIssues.pdf: $(DOC_SOURCE_PATH)/KnownIssues.rst $(DOC_SOURCE_PATH)/netresearch.style
		rst2pdf -b 1 -o $(DOC_INTERN_PATH)/KnownIssues.pdf -s $(DOC_SOURCE_PATH)/netresearch.style $(DOC_SOURCE_PATH)/KnownIssues.rst --real-footnotes



clean:
		rm -f $(DOC_PUBLIC_PATH)/*.pdf
		rm -f $(DOC_INTERN_PATH)/*.pdf

version:
		@echo === Making $(MODULE_KEY) version $(VERSION)

zip:
		@echo === Creating zip file $(ZIPFILE) from $(TMPPATH)
		rm -f $(ZIPFILE)
		rm -f $(ZIPNAME)
		rm -rf $(TMPPATH)
		mkdir -p $(TMPPATH)/doc
		cp -r $(ARCHIVE_COLLECTION) $(TMPPATH)
		cp -r doc/$(MODULE_KEY) $(TMPPATH)/doc/
		
		cd $(TMPPATH) && zip -rq $(ZIPFILE) *
		rm -rf $(TMPPATH)
		cd $(MODULE_PATH)
		cp -f $(ZIPFILE) $(ZIPNAME)
		rm -f $(ZIPFILE)
.PHONY: doc

