<?php

namespace spec;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CodeBreakerSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('1234');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('CodeBreaker');
    }

    function it_returns_empty_string_if_none_match()
    {
        $this->guess('5678')->shouldReturn('');
    }

    function it_returns_plus_if_one_match_on_right_position()
    {
        $this->guess('1567')->shouldReturn('+');
    }

    function it_returns_two_pluses_if_two_matches_on_right_position()
    {
        $this->guess('1267')->shouldReturn('++');
    }

    function it_returns_three_pluses_if_three_matches_on_right_position()
    {
        $this->guess('1235')->shouldReturn('+++');
    }

    function it_returns_four_pluses_if_everything_match_on_right_position()
    {
        $this->guess('1234')->shouldReturn('++++');
    }

    function it_returns_minus_if_one_match_on_wrong_position()
    {
        $this->guess('5671')->shouldReturn('-');
    }

    function it_returns_two_minuses_if_two_matches_on_wrong_position()
    {
        $this->guess('4563')->shouldReturn('--');
    }

    function it_returns_three_minuses_if_three_matches_on_wrong_position()
    {
        $this->guess('4513')->shouldReturn('---');
    }

    function it_returns_four_minuses_if_everything_matches_on_wrong_position()
    {
        $this->guess('4321')->shouldReturn('----');
    }

    function it_returns_plus_and_minus_if_both_matches_exist()
    {
        $this->guess('3564')->shouldReturn('+-');
    }

    function it_handles_all_other_configurations()
    {
        $this->guess('1345')->shouldReturn('+--');
        $this->guess('1423')->shouldReturn('+---');
        $this->guess('1245')->shouldReturn('++-');
        $this->guess('1243')->shouldReturn('++--');
    }

    function it_handles_multiplied_number_matches()
    {
        $this->beConstructedWith('1123');

        $this->guess('1111')->shouldReturn('++');
        $this->guess('1132')->shouldReturn('++--');
        $this->guess('4511')->shouldReturn('--');
    }
}
