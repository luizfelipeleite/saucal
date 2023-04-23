const { registerBlockType } = wp.blocks;
const { useState, useEffect } = wp.element;
const { ToggleControl, PanelBody } = wp.components;
const { InspectorControls } = wp.blockEditor;

function CustomBlockEdit(props) {
  const [data, setData] = useState({});

  useEffect(() => {
    fetch(ajax_var.url, {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: new URLSearchParams({
        'action': 'api_endpoint',
        'nonce': ajax_var.nonce,
      }),
    })
    .then(response => response.json())
    .then(responseJson => { console.log(responseJson); setData(responseJson.data) });
  }, []);

  return (
    <div className="wp-block-lfl-block">
      {data.headers &&
        Object.entries(data.headers).map(([key, value]) => (
          <p key={key}>
            <strong>{key}: </strong>
            {value}
          </p>
        ))}
    </div>
  );
}

registerBlockType("blocks/lfl-block", {
  title: "Luiz Felipe Leite",
  category: "widgets",
  attributes: {
    content: { type: "string" },
    columns: {
      type: "object",
      default: {
        header: '',
      },
    },
  },
  icon: "coffee",
  edit: CustomBlockEdit,
  save: () => null,
});