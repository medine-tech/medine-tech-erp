.PHONY:  generate-docs
generate-docs:
	./vendor/bin/sail php artisan l5-swagger:generate
