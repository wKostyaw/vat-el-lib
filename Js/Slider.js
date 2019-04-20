var i = 0;
var SPosition = 8;
var CPosition = 0;
var EPosition = 0;
var SliderItems = $(".ExampleSliderItem") /*document.getElementsByClassName("ExampleSliderItem")*/
var  width = $(".ExampleSliderItem").width();
function LeftButtonClick() {
	if (EPosition < 0) {
		EPosition = SPosition + width*2;
		for (CPosition = SPosition; CPosition <= EPosition; CPosition++) {
			for (i=0; i<=SliderItems.length-1; i++) {
				SliderItems[i].style.left = CPosition + 'px';
			}
		}
		SPosition = EPosition;
	}
}
function RightButtonClick() {
	if (EPosition > -width*(SliderItems.length-3)) {
		EPosition = SPosition - width*2;
		for (CPosition = SPosition; CPosition >= EPosition; CPosition--) {
			for (i=0; i<=SliderItems.length-1; i++) {
				SliderItems[i].style.left = CPosition + 'px';
			}
		}
		SPosition = EPosition;
	}
}