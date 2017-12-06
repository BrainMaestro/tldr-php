docker:
	docker build . -t tldr-php
	docker run -v $(PWD):/app -it tldr-php
