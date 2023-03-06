const { PluginDocumentSettingPanel } = wp.editPost;
const {
  PanelRow,
  DatePicker,
  ToggleControl,
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
  const { version, is_pre_release: isPrerelease, release_date: releaseDate } = meta;

  const onDateChange = (val) => {
    setMeta({ ...meta, release_date: val });
  };

  return (
    <>
      <PluginDocumentSettingPanel initialOpen name="release-notes" title="Release Info">
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
        <br />
        <PanelRow>
          <ToggleControl
            label={__('Pre-Release Toggle')}
            checked={isPrerelease}
            onChange={(val) => setMeta({ ...meta, is_pre_release: val })}
          />
        </PanelRow>
      </PluginDocumentSettingPanel>
    </>
  );
}

export default CustomBlockFields;
