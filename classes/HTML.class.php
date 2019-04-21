<?php 

class HTML {
  
  public $title;
  public $bootstrap = false;
  public $chartjs = false;
  public $siteName;
  //Toggles the navbar on and off
  public $navbar = true;
  
  function __construct($siteName = "Untitled", $title = "Untitled App" ) {
    $this->siteName = $siteName;
    $this->title = $title;
    
  }
  
  public function doctype($type = "html") {
    $html = $this->opentag("!DOCTYPE", $type);  
    return $html;
  }
  
  public function tag($tag, $attributes = null, $children = null) {
    if($attributes) {
      $html = "<".$tag." ".$attributes.">";
    } else {
      $html = $this->opentag($tag);
    }
    if($children) {
      if(is_array($children)) {
        foreach($children as $child) {
          $html .= $child;
        } 
      } else {
        $html .= $children;
      }
      
    }
    $html .= $this->closetag($tag);
    return $html;
  }
  
  public function open($type = "html") {
    $html = "<!DOCTYPE ".$type.">";
    return $html;
  }
  
  public function close() {
    $html = $this->closetag("html");
    return $html;
  }
  
  public function head() {
    $head_properties = array(
      "<title>".$this->title."</title>"
      );
    if($this->bootstrap) {
      array_push($head_properties, "<link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css\">");
    }
    $html = $this->tag("head",null, $head_properties);
    return $html;
  }
  
  public function footer() {
    $footer_properties = array();
    if($this->bootstrap) {
      array_push($footer_properties, '<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>');
      array_push($footer_properties, '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>');
      array_push($footer_properties, '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>');
    }
    if($this->chartjs) {
      $footer_properties[] = '<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js"></script>';
    }
    
    $html = $this->tag("footer",null, $footer_properties);
    return $html;
  }
  
  public function chart($width, $height, $labels, $data_sets, $type = "line") {
    $html = $this->tag("canvas", "id='chart' width='$width' height='$height'");
    $html .= $this->opentag("script");
    $html .= "window.onload = function() {";
    $html .= "var ctx = document.getElementById(\"chart\");";
    $html .= "var chart = new Chart(ctx, {";
    $html .= "type: '$type',";
    $html .= "data: {";
    $html .= "labels: [";
    foreach($labels as $label) {
      $html .= "'$label',";
    }
    $html .= "],";
    $html .= "datasets: [";
    
    foreach($data_sets as $set) {
      $label = $set['label'];
      $data = $set['data'];
      $html .= "{";
      $html .= "label: '$label',";
      $html .= "data: [";
      foreach($data as $cell){
        $html .= $cell . ",";
      }
      $html .= "]";
      $html .= "}";
    }
    $html .= "]},";// end data
    $html .= "});"; // end chart
    $html .= "};"; // end window listener
    $html .= $this->closetag("script");
    return $html;
  }
  
  private function opentag($tag, $attributes = null) {
    if($attributes) {
      return "<$tag $attributes>";
    } else {
      return "<$tag>";
    }
    
  }
  
  private function closetag($tag) {
    return "</".$tag.">";
  }
  
  public function render($html) {
    print $this->doctype();
    print $html;
  }
  
  public function renderContent($contentHTML) {
    $head = $this->head();

    $footer = $this->footer();
    $body = $this->tag("body", null, array($contentHTML, $footer));
    $render = $this->tag("html", null, array($head, $body));
    print $this->render($render);
  }
  
  public function airtable($data) {
    $html = "<table class='table'>";
    $html .= "<tr>";
    foreach($data[0]->fields as $key=>$field) {
      $html .= "<th scope='col'>";
      $html .= $key;
      $html .= "</th>";
    }
  
    
    foreach($data as $row) {
      $html .= "<tr>";
      foreach($row->fields as $cell) {
        $html .= "<td scope='row'>";
        $html .= $cell;
        $html .= "</td>";
      }
      $html .= "</tr>";
    }
    $html .= "</table>";
    return $html;
  }
  
  public function navbar($theme = "light", $data) {
    $html = "<nav class=\"navbar navbar-expand-lg navbar-$theme bg-$theme\">";
    $html .= "<a class=\"navbar-brand\" href=\"/\">$this->siteName</a>";
    //button
    $html .= "<button class=\"navbar-toggler\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">";
    $html .= "<span class=\"navbar-toggler-icon\"></span>";
    $html .= "</button>";
    
    $html .= "<div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">";
    $html .= "<ul class=\"navbar-nav mr-auto\">";
    // $html .= "<li class=\"nav-item active\">";
    // $html .= "<a class=\"nav-link\" href=\"#\">Home <span class=\"sr-only\">(current)</span></a>";
    // $html .= "</li>";
    foreach($data as $item) {
      $html .= "<li class=\"nav-item\">";
      $html .= "<a class=\"nav-link\" href=\"".$item->fields->href."\" target=\"".$item->fields->target."\">".$item->fields->Page."</a>";
      $html .= "</li>";
    }
    
    // $html .= "<li class=\"nav-item dropdown\">";
    // $html .= "<a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
    // $html .= "Dropdown";
    // $html .= "</a>";
    // $html .= "<div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">";
    // $html .= "<a class=\"dropdown-item\" href=\"#\">Action</a>";
    // $html .= "<a class=\"dropdown-item\" href=\"#\">Another action</a>";
    // $html .= "<div class=\"dropdown-divider\"></div>";
    // $html .= "<a class=\"dropdown-item\" href=\"#\">Something else here</a>";
    // $html .= "</div>";
    // $html .= "</li>";
    // $html .= "<li class=\"nav-item\">";
    // $html .= "<a class=\"nav-link disabled\" href=\"#\">Disabled</a>";
    // $html .= "</li>";
    $html .= "</ul>";
    // $html .= "<form class=\"form-inline my-2 my-lg-0\">";
    // $html .= "<input class=\"form-control mr-sm-2\" type=\"search\" placeholder=\"Search\" aria-label=\"Search\">";
    // $html .= "<button class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\">Search</button>";
    // $html .= "</form>";
    $html .= "</div>";
    $html .= "</nav>";
    return $html;
  }
  
  public function label($name, $label) {
    $html = $this->opentag("label", "for='$name'");
    $html .= $label;
    $html .= $this->closetag("label");
    return $html;
  }
  
}
