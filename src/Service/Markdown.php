<?hh // strict

namespace PLC\Service;

class Markdown
{
    public async function convertToHtml(?string $markdown): Awaitable<?string>
    {
        if ($markdown === null || $markdown === '') {
            return null;
        }

        $descriptorspec = [
           ['pipe', 'r'], // STDIN
           ['pipe', 'w'], // STDOUT
        ];

        $pipes   = [];
        $process = proc_open('pandoc -f markdown -t html', $descriptorspec, $pipes);

        if (!is_resource($process)) {
            return null;
        }

        fwrite($pipes[0], $markdown);
        fclose($pipes[0]);

        $html = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        proc_close($process);

        return $html;
    }
}
