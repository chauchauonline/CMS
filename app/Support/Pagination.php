<?php namespace App\Pagination;

use Illuminate\Pagination\BootstrapThreePresenter;

class Pagination extends BootstrapThreePresenter {

    /**
     * Get HTML wrapper for an available page link.
     *
     * @param  string  $url
     * @param  int  $page
     * @param  string|null  $rel1
     * @return string
     */
    protected function getAvailablePageWrapper($url, $page, $rel = null)
    {
        $rel1 = is_null($rel) ? '' : ' rel="'.$rel.'"';
        if ($rel == 'prev')
            return '<li><a href="'.htmlentities($url).'"'.$rel1.' class="back button">'.$page.'</a></li>';
        if ($rel == 'next')
            return '<li><a href="'.htmlentities($url).'"'.$rel1.' class="next button">'.$page.'</a></li>';
        return '<li><a href="'.htmlentities($url).'"'.$rel1.'>'.$page.'</a></li>';
    }

    /**
     * Get HTML wrapper for disabled text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getDisabledTextWrapper($text)
    {
        if ($text == '&laquo;'){
            return '<li class="disabled"><a class="back button">'.$text.'</a></li>';
        }
        if ($text == '&raquo;'){
            return '<li class="disabled"><a class="next button">'.$text.'</a></li>';
        }
        return '<li class="disabled"><a>'.$text.'</a></li>';
    }

    /**
     * Get HTML wrapper for active text.
     *
     * @param  string  $text
     * @return string
     */
    protected function getActivePageWrapper($text)
    {
        return '<li><a class="active">'.$text.'</a></li>';
    }

    /**
     * Get first page.
     *
     * @param  string  $text
     * @return url page
     */
    public function getFirst($text = null)
    {
        $text ='Đầu';
        if ($this->currentPage() <= 1)
        {
            return $this->getDisabledTextWrapper($text);
        }
        else
        {
            $url = $this->paginator->url(1);
            return $this->getPageLinkWrapper($url, $text);
        }
    }

    /**
     * Get last page.
     *
     * @param  string  $text
     * @return url page
     */
    public function getLast($text = null)
    {
        $text = 'Cuối';
        if ($this->currentPage() >= $this->lastPage())
        {
            return $this->getDisabledTextWrapper($text);
        }
        else
        {
            $url = $this->paginator->url($this->lastPage());
            return $this->getPageLinkWrapper($url, $text);
        }
    }
    
    /**
     * render html pagination
     *
     * @return string
     */
    public function render()
    {
        if ($this->currentPage() == 1) {
            $content = $this->getLinks(1, $this->currentPage() + 2); 
        }
        else if ($this->currentPage() >= $this->lastPage()) {
            $content = $this->getLinks($this->currentPage() - 2, $this->lastPage()); 
        }
        else {
            $content = $this->getLinks($this->currentPage() - 1, $this->currentPage() + 1); 
        }
        return $this->getFirst().$this->getPreviousButton().$content.$this->getNextButton().$this->getLast();
    }
}