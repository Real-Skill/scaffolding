require_relative "spec_helper"
require_relative "../exercises/ruby_exercise1"

describe "RubyExercise1" do

  describe "SimpleNumber" do
    let(:number) { rand(1000)}
    let(:simpleNumber)  { RubyExercise1::SimpleNumber.new(number) }

    context "#add" do

      it "should return sum value" do
        expect(simpleNumber.add(4)).to eql(number + 4)
      end
    end
  end
end
