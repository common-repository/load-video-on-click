function eos_load_on_click_addCustomAttributes(settings,name){
  if(('core/video' === settings.name || 'core/embed' === settings.name) && settings.attributes){
    settings.attributes = Object.assign(settings.attributes, {
      loadOnClick: {
        type: 'boolean',
      }
    });
  }
  return settings;
}

wp.hooks.addFilter(
  'blocks.registerBlockType',
  'loadVideoOnCLick/addCustomParameter',
  eos_load_on_click_addCustomAttributes
);

var coverAdvancedControls = wp.compose.createHigherOrderComponent(function (BlockEdit) {
	return function (props) {
		var Fragment = wp.element.Fragment,
    ToggleControl = wp.components.ToggleControl,
    InspectorAdvancedControls = wp.blockEditor.InspectorAdvancedControls,
    attributes = props.attributes,
    setAttributes = props.setAttributes,
    isSelected = props.isSelected;
		return React.createElement(
			Fragment,
			null,
			React.createElement(BlockEdit, props),
			isSelected && (props.name == 'core/video' || props.name == 'core/embed') && React.createElement(
				InspectorAdvancedControls,
				null,
				React.createElement(ToggleControl, {
					label: wp.i18n.__('Load on click', 'loadVideoOnClick'),
					checked: !!attributes.loadOnClick,
					onChange: function (newval) {
						return setAttributes({ loadOnClick: !attributes.loadOnClick });
					}
				})
			)
		);
	};
},'coverAdvancedControls');

wp.hooks.addFilter(
	'editor.BlockEdit',
	'awp/cover-advanced-control',
	coverAdvancedControls
);
