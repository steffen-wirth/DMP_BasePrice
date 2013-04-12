######################################################
# Start edit here
VENDOR:=DerModPro
MODULE:=BasePrice
ARCHIVE_COLLECTION:=app skin
# End edit here
######################################################

######################################################
# Build script variables
MODULE_KEY:=$(VENDOR)_$(MODULE)
DATE:=$(shell date +%s)
VERSION:=$(shell grep "<version>" app/code/community/$(VENDOR)/$(MODULE)/etc/config.xml | sed -e :a -e 's/<[^>]*>//g;/</N;//ba;s/ //g')

#Paths for tar and zip-file
MODULE_PATH:=$(shell pwd)
TMPPATH:=/tmp/$(MODULE).$(DATE)
ZIPNAME:=$(MODULE)_$(VERSION).zip
TARNAME:=$(MODULE)_$(VERSION).tar
ZIPFILE:=/tmp/$(ZIPNAME)
TARFILE:=/tmp/$(TARNAME)

# Doc folders
DOCPATH:=doc
DOC_PUBLIC_PATH:=$(DOCPATH)/$(MODULE_KEY)
DOC_INTERN_PATH:=$(DOCPATH)/Intern
DOC_SOURCE_PATH:=$(DOCPATH)/src
######################################################

all: clean version doc zip tar

doc: $(DOC_PUBLIC_PATH)/ChangeLog.pdf $(DOC_INTERN_PATH)/Specification.pdf $(DOC_INTERN_PATH)/KnownIssues.pdf $(DOC_INTERN_PATH)/Entwicklerdokumentation.pdf

$(DOC_PUBLIC_PATH)/ChangeLog.pdf: $(DOC_SOURCE_PATH)/ChangeLog.rst $(DOC_SOURCE_PATH)/netresearch.style
		rst2pdf -b 1 -o $(DOC_PUBLIC_PATH)/ChangeLog.pdf -s $(DOC_SOURCE_PATH)/netresearch.style $(DOC_SOURCE_PATH)/ChangeLog.rst --real-footnotes
		
$(DOC_INTERN_PATH)/Specification.pdf: $(DOC_SOURCE_PATH)/Specification.rst $(DOC_SOURCE_PATH)/netresearch.style
		rst2pdf -b 1 -o $(DOC_INTERN_PATH)/Specification.pdf -s $(DOC_SOURCE_PATH)/netresearch.style $(DOC_SOURCE_PATH)/Specification.rst --real-footnotes
		
$(DOC_INTERN_PATH)/KnownIssues.pdf: $(DOC_SOURCE_PATH)/KnownIssues.rst $(DOC_SOURCE_PATH)/netresearch.style
		rst2pdf -b 1 -o $(DOC_INTERN_PATH)/KnownIssues.pdf -s $(DOC_SOURCE_PATH)/netresearch.style $(DOC_SOURCE_PATH)/KnownIssues.rst --real-footnotes

$(DOC_INTERN_PATH)/Entwicklerdokumentation.pdf: $(DOC_SOURCE_PATH)/Entwicklerdokumentation.rst $(DOC_SOURCE_PATH)/netresearch.style
		rst2pdf -b 1 -o $(DOC_INTERN_PATH)/Entwicklerdokumentation.pdf -s $(DOC_SOURCE_PATH)/netresearch.style $(DOC_SOURCE_PATH)/Entwicklerdokumentation.rst --real-footnotes



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

tar:
		@echo === Creating tar file $(TARFILE) from $(TMPPATH)
		rm -f $(TARFILE)
		rm -f $(TARNAME)
		rm -rf $(TMPPATH)
		mkdir -p $(TMPPATH)/doc
		cp -r $(ARCHIVE_COLLECTION) $(TMPPATH)
		cp -r doc/$(MODULE_KEY) $(TMPPATH)/doc/
		
		cd $(TMPPATH) && tar -cf $(TARFILE) *
		rm -rf $(TMPPATH)
		cd $(MODULE_PATH)
		cp -f $(TARFILE) $(TARNAME)
		rm -f $(TARFILE)

.PHONY: doc

