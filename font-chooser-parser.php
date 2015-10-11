<?php

/**
 * Content parser
 */
class FontChooserParser
{
  // list of supported fonts
  private static $s_asSupportedFonts = array
  (
      "Arial",
      "Arial Black",
      "Comic Sans MS",
      "Courier New",
      "Georgia1",
      "Impact",
      "Lucida Console",
      "Tahoma",
      "Times New Roman",
      "Trebuchet MS1",
      "Verdana",
      "Symbol",
      "Webdings",
      "Wingdings"
  );

  /**
   * Parse a content string and make font-span replacements
   *
   * @param string $sContent   the content of the page being displayed
   * @return string            the (possibly modified) content
  */
  public function parse(&$sContent)
  {
    // loop content and look for simple font tags
    $nPosition = 0;
    $sModified = "";

    for ($nContent = strlen($sContent), $nPosition = 0; $nPosition < $nContent; $nPosition ++)
    {
      if ($sContent{$nPosition} == '[')
      {
        $nPosition ++;

        // make sure this isn't the end
        if ($nPosition >= $nContent)
        {
          $sModified .= '[';
          break;
        }

        // grab the following section of the content for comparison
        $sPossible = substr($sContent, $nPosition, 32);

        foreach (FontChooserParser::$s_asSupportedFonts as $sFont)
        {
          if (!strncmp($sPossible, $sFont, strlen($sFont)))
          {
            // supported font match
            $sModified .= '<span style="font-family: '.$sFont.';">';

            $nPosition += strlen($sFont) + 1;

            while (($c = $sContent{$nPosition}) != ']')
            {
              if (($c == '\\') && ($sContent{$nPosition + 1} == ']'))
                $sModified .= $sContent{++$nPosition};

              else
                $sModified .= $c;

              $nPosition ++;
            }

            $sModified .= '</span>';
          }
        }
      }

      else
        $sModified .= $sContent{$nPosition};
    }

    return $sModified;
  }
}
