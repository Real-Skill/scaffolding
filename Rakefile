begin
  require 'rspec/core/rake_task'

  RSpec::Core::RakeTask.new(:verify) do |t, task_args|
    t.rspec_opts = "--format RspecJunitFormatter --out target/test-results.xml spec"
  end
rescue LoadError
  # no rspec available
end
