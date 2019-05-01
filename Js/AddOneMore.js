$(document).ready(), function() {
$('.File').each(function() {
		var $input = $(this),
			$Container = $input.next('.AddFileContainer'),
			Nothing = $Container.html();
		$input.on('change', function(e) {
			var FileName = '';
			if(this.files && this.files.length > 1)
				FileName = (this.getAttribute('data-multiple-caption') || '').replace('{count}', this.files.length);
			else if(e.target.value)
				FileName = e.target.value.split('\\').pop();

			if(FileName)
				$Container.find('.LFName').html(FileName);
			else
				$Container.html(Nothing);
		});
});
}();