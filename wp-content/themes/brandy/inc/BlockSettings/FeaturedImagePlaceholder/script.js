function isFeaturedImageBlock(name) {
  return name === "core/post-featured-image";
}

/** Register attribute */
function addFeaturedImagePlaceholderAttributes(settings) {
  if (typeof settings.attributes === "undefined") {
    return settings;
  }
  if (!isFeaturedImageBlock(settings)) {
    return settings;
  }
  settings.attributes = Object.assign(settings.attributes, {
    showPlaceholder: {
      type: "boolean",
      default: true,
    },
  });

  return settings;
}

wp.hooks.addFilter(
  "blocks.registerBlockType",
  "brandy-blocks/featured-image-placeholder-attribute",
  addFeaturedImagePlaceholderAttributes
);

/** Display controls */

const FeaturedImagePlaceholderControls = wp.compose.createHigherOrderComponent(
  (BlockEdit) => {
    return (props) => {
      const { Fragment } = wp.element;
      const { ToggleControl, PanelBody } = wp.components;
      const { InspectorControls } = wp.blockEditor;
      const { isSelected, attributes, setAttributes, name } = props;
      const canAddSettings = isFeaturedImageBlock(name);

      return React.createElement(
        Fragment,
        null,
        React.createElement(BlockEdit, props),
        isSelected &&
          canAddSettings &&
          React.createElement(
            InspectorControls,
            null,
            React.createElement(
              PanelBody,
              {
                title: wp.i18n.__("Placeholder", "brandy"),
              },
              React.createElement(ToggleControl, {
                label: wp.i18n.__(
                  "Show placeholder when not have image",
                  "brandy"
                ),
                checked: attributes?.showPlaceholder ?? true,
                onChange: (value) => {
                  setAttributes({
                    showPlaceholder: value,
                  });
                },
              })
            )
          )
      );
    };
  },
  "FeaturedImagePlaceholderControls"
);

wp.hooks.addFilter(
  "editor.BlockEdit",
  "brandy-blocks/featured-image-placeholder-controls",
  FeaturedImagePlaceholderControls
);