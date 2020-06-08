"use strict";

$(document).ready(function() {
 $('.header').height($(window).height()/1.5); // находим и устанавливаем высоту раздела 

 $(".navbar a").click(function() { // прописываем поведение ссылок в нав.панели
  	$("body,html").animate({
  		scrollTop:$("#" + $(this).data('value')).offset().top
  	},1000);
 $('a.top[href^="#"]').bind('click.smoothscroll',function (e) { // прописываем поведение скролла вверх
  		e.preventDefault();
  
  		let target = this.hash,
  		$target = $(target);
  
  		$('html, body').stop().animate({
  			'scrollTop': $target.offset().top-75
  		}, 900, 'swing', function () {
  			window.location.hash = target;
  		});
  	});
   });
    // рабочий код для кнопки показать/скрыть, но чтобы он корректно отрабатывлтолько на одной карточке надо поиграться со стилями для .card-text
 /*   $('.more-btn').click(function(){
    $(this).toggleClass('active');
    let cardText = this.parentElement.parentElement.querySelector(".card-text"); // определям,какая именно кнопка активна в данный момент и затем уже вводим  toggleClass('opener')
    $(cardText).toggleClass('opener'); 
    if (!$(this).data('status')) {
        $(this).data('status', true).html('Скрыть');
    } else {
      $(this).data('status', false).html('Подробнее');
    }
  });*/
});

class Card { // создаем объект  через Конструктор и находим все необходимые данные
  constructor(elem) {
    this.elem = elem;
    this.textElem = elem.querySelector(".card-text");
    this.fullText = this.textElem.innerHTML;
    this.moreBtn = elem.querySelector(".more-btn");
    this.moreBtn.onclick = this.showMore.bind(this); // bind(this) позволяет решить вопрос с видимостью this в объекте
    this.textElem.innerHTML = this.fullText.slice(0, 100); // скрываем текст после 100 символов
  }
  showMore() { // создаем метод для кнопки "подробнее"
    if(this.textElem.innerHTML != this.fullText) {
      this.textElem.innerHTML = this.fullText;
      this.moreBtn.innerHTML = "Скрыть";
      this.moreBtn.onclick = this.hideText.bind(this);
     //console.log("Показать подробнее"); для проверки кода
    }
  }
  hideText() { // создаем метод для скрытия текста по нажатию на кнопку "скрыть"
      if(this.textElem.innerHTML == this.fullText) {
      this.moreBtn.onclick = this.showMore.bind(this);
      this.moreBtn.innerHTML = "Подробнее";
      this.textElem.innerHTML = this.fullText.slice(0, 100); //скрываем текст до уровня 100 символов.
    }
  }
}  
 // создаем массив 
let cards = [];
let cardsElems = document.querySelectorAll(".card-block");
for (let card of cardsElems) {
  cards.push(new Card(card));
}
