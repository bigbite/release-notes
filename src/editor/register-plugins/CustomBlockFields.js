const { PluginDocumentSettingPanel } = wp.editPost;
const {
  PanelRow,
  DatePicker,
  __experimentalInputControl: InputControl,
  __experimentalText: Text,
  __experimentalVStack: VStack,
} = wp.components;
const { useEntityProp } = wp.coreData;
const { useSelect } = wp.data;
const { __ } = wp.i18n;

/** Adds the date selector to the post settings */
function CustomBlockFields() {
  const postType = useSelect((select) => select('core/editor').getCurrentPostType(), []);
  if (postType !== 'release-note') return null;

  const [meta, setMeta] = useEntityProp('postType', postType, 'meta');
  const { version, 'release-date': releaseDate } = meta;

  const onDateChange = (val) => {
    setMeta({ ...meta, release_date: val });
  };

  return (
    <>
      <PluginDocumentSettingPanel initialOpen>
        <PanelRow>
          <InputControl
            value={version}
            onChange={(val) => setMeta({ ...meta, version: val })}
            label={__('Version Number')}
          />
        </PanelRow>
        <br />
        <PanelRow>
          <VStack>
            <Text variant="label">{__('Release Date')}</Text>
            <DatePicker
              currentDate={releaseDate}
              onChange={(val) => onDateChange(new Date(val).toISOString().split('T')[0])}
            />
          </VStack>
        </PanelRow>
      </PluginDocumentSettingPanel>
    </>
  );
}

export default CustomBlockFields;
