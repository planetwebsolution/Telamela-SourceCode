   $(document).ready(function() {
      
        var owl = $(".owl-demo");
      
        owl.owlCarousel({
      
        items :3, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
        });
      
        // Custom Navigation Events
        $(".next").click(function(){
          owl.trigger('owl.next');
        })
        $(".prev").click(function(){
          owl.trigger('owl.prev');
        });
		
		
		   
        var owl1 = $(".owl-demo1");
      
        owl1.owlCarousel({
      
        items :3, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
        });
      
        // Custom Navigation Events
        $(".next1").click(function(){

          owl1.trigger('owl.next');
        })
        $(".prev1").click(function(){
          owl1.trigger('owl.prev');
        })
		
		
		 var owl2 = $(".owl-demo2");
      
        owl2.owlCarousel({
      
        items :5, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
        });
      
        // Custom Navigation Events
        $(".next2").click(function(){

          owl2.trigger('owl.next');
        })
        $(".prev2").click(function(){
          owl2.trigger('owl.prev');
        })
		
		
		var owl3 = $(".owl-demo3");
      
        owl3.owlCarousel({
      
        items :3, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,3], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
        });
      
        // Custom Navigation Events
        $(".next3").click(function(){

          owl3.trigger('owl.next');
        })
        $(".prev3").click(function(){
          owl2.trigger('owl.prev');
        })
		
		var owl4 = $(".owl-demo4");
      
        owl4.owlCarousel({
      
        items :3, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,5], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
        });
      
        // Custom Navigation Events
        $(".next4").click(function(){

          owl4.trigger('owl.next');
        })
        $(".prev4").click(function(){
          owl2.trigger('owl.prev');
        })
		
		var owl6 = $(".owl-demo6");
      
        owl6.owlCarousel({
      
        items :1, //10 items above 1000px browser width
        itemsDesktop : [1000,5], //5 items between 1000px and 901px
        itemsDesktopSmall : [900,5], // 3 items betweem 900px and 601px
        itemsTablet: [600,2], //2 items between 600 and 0;
        itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
        
        });
      
        // Custom Navigation Events
        $(".next6").click(function(){

          owl6.trigger('owl.next');
        })
        $(".prev6").click(function(){
          owl6.trigger('owl.prev');
        })
		
		     
      });
	  
	  