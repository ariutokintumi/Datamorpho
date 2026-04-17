PYTHON ?= python3
PYTEST ?= pytest
PYTHONPATH_VALUE := ./python

.PHONY: help install test create reconstruct clean

help:
	@echo "Available targets:"
	@echo "  install       Install Python dependencies"
	@echo "  test          Run Python tests"
	@echo "  create        Run example creator command (set CARRIER, STATE, optional STATE2..STATE5, SUITE, LAYOUT, OUT)"
	@echo "  reconstruct   Run example reconstructor command (set CARRIER, RECON, optional OUT)"
	@echo "  clean         Remove common local output directories and caches"

install:
	$(PYTHON) -m pip install -r python/requirements.txt

test:
	PYTHONPATH=$(PYTHONPATH_VALUE) $(PYTEST) -q python/datamorpho/tests

create:
ifndef CARRIER
	$(error CARRIER is required, e.g. make create CARRIER=./base.jpg STATE=./secret.txt)
endif
ifndef STATE
	$(error STATE is required, e.g. make create CARRIER=./base.jpg STATE=./secret.txt)
endif
	PYTHONPATH=$(PYTHONPATH_VALUE) $(PYTHON) -m datamorpho.cli.create \
		--carrier "$(CARRIER)" \
		--state "$(STATE)" \
		$(if $(STATE2),--state "$(STATE2)") \
		$(if $(STATE3),--state "$(STATE3)") \
		$(if $(STATE4),--state "$(STATE4)") \
		$(if $(STATE5),--state "$(STATE5)") \
		--suite "$(or $(SUITE),simple)" \
		--layout "$(or $(LAYOUT),sparse-with-chaff)" \
		--out-dir "$(or $(OUT),./out)"

reconstruct:
ifndef CARRIER
	$(error CARRIER is required, e.g. make reconstruct CARRIER=./out/base.datamorph.jpg RECON=./out/reconstruction-state-1.json)
endif
ifndef RECON
	$(error RECON is required, e.g. make reconstruct CARRIER=./out/base.datamorpho.jpg RECON=./out/reconstruction-state-1.json)
endif
	PYTHONPATH=$(PYTHONPATH_VALUE) $(PYTHON) -m datamorpho.cli.reconstruct \
		--carrier "$(CARRIER)" \
		--reconstruction "$(RECON)" \
		--out-dir "$(or $(OUT),./recovered)"

clean:
	rm -rf out recovered python/.pytest_cache
	find python -type d -name "__pycache__" -prune -exec rm -rf {} +
	find python -type f -name "*.pyc" -delete