function isSupportedBlock(settings) {
  return ["core/group", "core/column", "core/buttons", "core/paragraph", "core/heading"].includes(settings.name);
}

const PRIORITY = 9;

const DEFAULT_VALUE = {
  textAlign: {
    tablet: {
      enabled: false,
      value: "center",
    },
    mobile: {
      enabled: false,
      value: "center",
    },
  },
  justifyContent: {
    tablet: {
      enabled: false,
      value: "center",
    },
    mobile: {
      enabled: false,
      value: "center",
    },
  },
};

/** Register attribute */
function addContentResponsiveControlsAttributes(settings) {
  if (typeof settings.attributes === "undefined") {
    return settings;
  }
  if (!isSupportedBlock(settings)) {
    return settings;
  }
  settings.attributes = Object.assign(settings.attributes, {
    responsiveControls: {
      type: "object",
      default: {},
    },
  });

  return settings;
}

wp.hooks.addFilter(
  "blocks.registerBlockType",
  "brandy-blocks/content-responsive-controls-attribute",
  addContentResponsiveControlsAttributes
);

/** Display controls */

const ContentResponsiveControls = wp.compose.createHigherOrderComponent(
  (BlockEdit) => {
    return (props) => {
      const { Fragment } = wp.element;
      const {
        ToggleControl,
        PanelBody,
        __experimentalToggleGroupControl: ToggleGroupControl,
        __experimentalToggleGroupControlOption: ToggleGroupControlOption,
      } = wp.components;
      const { InspectorControls } = wp.blockEditor;
      const { isSelected, attributes, setAttributes } = props;
      const canAddSettings = isSupportedBlock(props);
      const { useSelect } = wp.data;
      const previewDevice = useSelect((select) =>
        (
          (
            select("core/edit-post") ?? select("core/edit-site")
          )?.__experimentalGetPreviewDeviceType() ?? ""
        ).toLowerCase()
      );

      if (previewDevice === "desktop") {
        return React.createElement(BlockEdit, props);
      }

      const justificationOptions = [
        {
          value: "left",
          label: wp.i18n.__("Left"),
        },
        {
          value: "center",
          label: wp.i18n.__("Center"),
        },
        {
          value: "right",
          label: wp.i18n.__("Right"),
        },
      ];

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
                title: wp.i18n.__("Content Responsive Controls", "brandy"),
              },
              React.createElement(ToggleControl, {
                label: wp.i18n.__(
                  `Enable Text Align on ${previewDevice}`,
                  "brandy"
                ),
                checked:
                  attributes?.responsiveControls?.textAlign?.[previewDevice]
                    ?.enabled ?? false,
                onChange: (value) => {
                  const newValue = {
                    ...JSON.parse(JSON.stringify(DEFAULT_VALUE)),
                    ...(attributes.responsiveControls ?? {}),
                  };
                  newValue.textAlign[previewDevice].enabled = value;
                  setAttributes({
                    responsiveControls: newValue,
                  });
                },
              }),
              attributes?.responsiveControls?.textAlign?.[previewDevice]
                ?.enabled &&
                React.createElement(ToggleGroupControl, {
                  __next40pxDefaultSize: true,
                  __nextHasNoMarginBottom: true,
                  label: wp.i18n.__("Text Align"),
                  value:
                    attributes?.responsiveControls?.textAlign?.[previewDevice]
                      ?.value ?? "center",
                  onChange: (value) => {
                    const newValue = {
                      ...JSON.parse(JSON.stringify(DEFAULT_VALUE)),
                      ...(attributes.responsiveControls ?? {}),
                    };
                    newValue.textAlign[previewDevice].value = value;
                    setAttributes({
                      responsiveControls: newValue,
                    });
                  },
                  children: justificationOptions.map((option) =>
                    React.createElement(ToggleGroupControlOption, {
                      value: option.value,
                      label: option.label,
                    })
                  ),
                }),
              React.createElement(ToggleControl, {
                label: wp.i18n.__(
                  `Enable Justify Content on ${previewDevice}`,
                  "brandy"
                ),
                checked:
                  attributes?.responsiveControls?.justifyContent?.[
                    previewDevice
                  ]?.enabled ?? false,
                onChange: (value) => {
                  const newValue = {
                    ...JSON.parse(JSON.stringify(DEFAULT_VALUE)),
                    ...(attributes.responsiveControls ?? {}),
                  };
                  newValue.justifyContent[previewDevice].enabled = value;
                  setAttributes({
                    responsiveControls: newValue,
                  });
                },
              }),
              attributes?.responsiveControls?.justifyContent?.[previewDevice]
                ?.enabled &&
                React.createElement(ToggleGroupControl, {
                  __next40pxDefaultSize: true,
                  __nextHasNoMarginBottom: true,
                  label: wp.i18n.__("Justification"),
                  value:
                    attributes?.responsiveControls?.justifyContent?.[
                      previewDevice
                    ]?.value ?? "center",
                  onChange: (value) => {
                    const newValue = {
                      ...JSON.parse(JSON.stringify(DEFAULT_VALUE)),
                      ...(attributes.responsiveControls ?? {}),
                    };
                    newValue.justifyContent[previewDevice].value = value;
                    setAttributes({
                      responsiveControls: newValue,
                    });
                  },
                  children: justificationOptions.map((option) =>
                    React.createElement(ToggleGroupControlOption, {
                      value: option.value,
                      label: option.label,
                    })
                  ),
                })
            )
          )
      );
    };
  },
  "ContentResponsiveControls"
);

wp.hooks.addFilter(
  "editor.BlockEdit",
  "brandy-blocks/content-responsive-controls",
  ContentResponsiveControls,
  PRIORITY
);

const AddContentResponsiveControlsStyleToBlock =
  wp.compose.createHigherOrderComponent((BlockListBlock) => {
    return (props) => {
      const {
        attributes,
        block: { name: blockName },
      } = props;

      const extraProps = props;
      extraProps.className = props.className ?? "";

      const devices = ["tablet", "mobile"];

      if (isSupportedBlock(props.block)) {
        let groupType = "group";

        if (attributes.layout?.type === "flex") {
          if (attributes.layout?.orientation === "vertical") {
            groupType = "stack";
          } else {
            groupType = "row";
          }
        }

        let justifyType = "justify";
        if (groupType === "stack") {
          justifyType = "items";
        }

        devices.forEach((device) => {
          const prefix = device === "tablet" ? "md" : "sm";
          if (attributes.responsiveControls?.textAlign?.[device]?.enabled) {
            extraProps.className += ` ${prefix}-text-${
              attributes.responsiveControls?.textAlign?.[device]?.value ??
              "center"
            }`;
          }
          if (
            attributes.responsiveControls?.justifyContent?.[device]?.enabled
          ) {
            extraProps.className += ` ${prefix}-${justifyType}-${
              attributes.responsiveControls?.justifyContent?.[device]?.value ??
              "center"
            }`;
          }
        });
      }

      return React.createElement(BlockListBlock, extraProps);
    };
  }, "AddContentResponsiveControlsStyleToBlock");

wp.hooks.addFilter(
  "editor.BlockListBlock",
  "brandy/content-responsive-controls-style",
  AddContentResponsiveControlsStyleToBlock,
  PRIORITY
);
