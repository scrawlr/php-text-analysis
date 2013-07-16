<?php
namespace TextAnalysis\Aggregates;

use TextAnalysis\Analysis\FreqDist;
use TextAnalysis\Aggregates\BigramAggregate;

/**
 * Get the collocation of the provided set of tokens, by default it uses bigrams
 * @author yooper
 */
class CollocationAggregate 
{    
    /**
     * Set the size of the nGram to scan for
     * @todo implement
     * @var int 
     */
    static public $nGramSize = 2;
   
    /**
     * The text 
     * @var string 
     */
    protected $text = null;
    
    /**
     * The set of tokens generated by the tokenizer
     * @var array 
     */
    protected $tokens = null;
    
    
    public function __construct($text, array $tokens) 
    {
        $this->text = $text;
        $this->tokens = $tokens;
    }
  
    /**
     * Returns a sorted array with the key being the phrase and value being
     * the number of times it is mentioned in the text
     * @return \ArrayIterator
     */
    public function getAggregate()
    { 
        $nGramAggregate = new BigramAggregate($this->tokens);
        $tokenMetaAggregate = new TokenMetaAggregator($this->text, $nGramAggregate->getAggregateStrings());
        $freqDist = new FreqDist($tokenMetaAggregate->getAggregate());
        return $freqDist->getKeyValues();
        
    }
    
}

