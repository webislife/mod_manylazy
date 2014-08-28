<?php 
defined('_JEXEC') or die('Restricted access');
$prods = ModManyLazyHelper::getProdsRand($prod_count);
// var_dump($prods); 
?>
<style>
	
</style>
<div class="row-fluid">
	<div class="span12">	
	<div class="lazy_start_show">Посмотреть бесконечный ассортимент!</div>
	</div>
</div>
<div class="row-fluid" id="main_lazy_container">
	
	<div class="span12 lazy_container_prods">
		<?
	foreach($prods as $p)
	{
	?>
	<div class="lazy_block_product">
	<div class="lazy_block_image image_cont">
		<img src="<? echo $p['image_url']; ?>" alt="<? echo $p['name']; ?>">
	</div>
	<div class="product_price_block">
		<? echo $p['price'].' руб.'; ?>
	</div>
	<div class="product_title">
		<p class="lazy_category_link">
			Категория: <a  href="<? echo $p['cat_url'];?>"><? echo $p['cat_name']; ?></a>
		</p>
		<a class="lazy_product_link" href="<? echo $p['product_url'];?>"><? echo $p['name']; ?></a>
	</div>
	</div>
	<?	
	}
	?>
	</div>
	<div class="span12">
	<div class="lazy_loader_trigger"><p class="lazy_loader">Загружаем еще...</p></div>
	</div>
</div>
<script>

	jQuery(document).ready(function($) {
		//Текущий статус загрузки, чтобы не плодить кочу запросов к серверу. Пока не выполнен один запрос, второй отсылать не будем.
		var currentload = false;

		//Наша функция подгрузки товаров
		var lazyLoader = function()
		{
			//Определяем высоту прокрутки
			var wt = $(window).scrollTop();

			//Получаем позицию низа экрана
			var wb = wt + $(window).height(); 

			//Получаем значение отступа нашего блока подгрузчика
			var lt = $('.lazy_loader_trigger').offset().top;

			//Если низ экрана стал ниже отступа блока подгрузчика и текущая загрузка не запущена
			if(wb > lt && currentload == false)
			{
				//Посылаем запрос
				$.ajax({

					//Все стандартно, при необходимости можно и данные передать
					url: '/modules/mod_manylazy/ajax.php',
					type: 'POST',
					dataType: 'json',
					data: {},
					success: function(data, status)
					{
						//Формируем html шаблон из возвращенного json ответа
						var html = '';
						var l = data.length;
						for(var key in data)
						{
							var val = data[key];
							//Иногда ответ может придти пустым... проверяем.
							if(val['price'] != undefined) {
							//Разметка
							html += '<div class="lazy_block_product">';
							html += '<div class="lazy_block_image image_cont">';
							html += '<img src="'+val['image_url']+'" alt="'+val['name']+'" /></div>';
							html += '<div class="product_price_block">'+val['price']+' руб.</div>';
							html += '<div class="product_title">';
							html += '<p class="lazy_category_link">Категория: <a  href="http://manytomany.ru'+val['cat_url']+'">'+val['cat_name']+'</a></p>';
							html += '<a class="lazy_product_link" href="http://manytomany.ru'+val['product_url']+'">'+val['name']+'</a>';
							html += '</div>';
							html += '</div>';
							}
						}
						//Добавляем новые блоки
						$('.lazy_container_prods').append(html);
						currentload = false;
					},
					//Перед отправкой показываем лоадер
					before: function()
					{
						$('.lazy_loader').show();
						currentload = true;
					},
					//Ошибку просто выводим в консоль
					error: function(data)
					{
						console.error(data);
					}

				});

			}
		}
		$('.lazy_start_show').on('click', function()
			{
		$('#main_lazy_container').show(300);				
		$(window).on('scroll', lazyLoader);	
			});
	});
</script>

