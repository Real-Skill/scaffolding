bundle exec rake db:create
bundle exec rake db:test:prepare
bundle exec rspec --format RspecJunitFormatter --out target/test-results.xml
