<?pbp

namespace LINE\Bot\Response;

use LINE\Bot\Bot;

class Command
{
	use CommandRoutes;
	private $routes = [];
	public function __construct(Bot $bot)
	{
		$this->b = $bot;
	}
	
	private function route(Closure $cond, $act)
	{
		$this->routes[] = [$cond, $act];
	}
	
	private function _route()
	{
		foreach ($this->routes as $val) {
			if ($val[0]()) {
				return $val[1]();
			}
		}
	}
	
	public function run()
	{
		$this->writeRoutes();
		$this->_route();
	}
}