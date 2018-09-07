<?php
namespace Medal\Library;
class View
{
    protected $path, $controller, $action, $template_path;
    public function __construct($path, $template_path, $controllerName, $actionName)
    {
        $this->path       = $path;
        $this->template_path = $template_path;
        $this->controller = $controllerName;
        $this->action     = $actionName;
    }
    public function setVars(array $vars)
    {
        foreach ($vars as $key => $val) {
            $this->vars[$key] = $val;
        }
    }
    /**
     * Render the view.
     *
     * @throws NotFoundException
     */
    public function render()
    {
        $this->render_header();
        $fileName = $this->path.DIRECTORY_SEPARATOR.$this->controller.DIRECTORY_SEPARATOR.$this->action.'.phtml';
        if (!file_exists($fileName)) {
            throw new NotFoundException();
        }
        // spare the view the bloat of using "$this->vars[]" for every variable
         foreach ($this->vars as $key => $val) {
             $$key = $val;
         }
        include $fileName;
        
        $this->render_footer();
    }
    
    public function setArray(array $vars, $key)
    {
        $this->vars[$key] = $vars;
        
    }
    
    private function render_header()
    {
        $header = $this->template_path.DIRECTORY_SEPARATOR.'header.phtml';
        include $header;
    }
    
    private function render_navigation()
    {
        $header = $this->template_path.DIRECTORY_SEPARATOR.'navigation.phtml';
        include $header;
    }
    
    private function render_footer()
    {
        $footer = $this->template_path.DIRECTORY_SEPARATOR.'footer.phtml';
        include $footer;
    }
} 