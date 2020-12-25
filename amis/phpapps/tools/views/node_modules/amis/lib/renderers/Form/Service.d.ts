import React from 'react';
import BasicService, { ServiceProps, ServiceSchema } from '../Service';
import { Payload } from '../../types';
import { IScopedContext } from '../../Scoped';
import { FormBaseControl, FormControlSchema } from './Item';
/**
 * Sevice
 * 文档：https://baidu.gitee.io/amis/docs/components/form/sevice
 */
export interface ServiceControlSchema extends FormBaseControl, ServiceSchema {
    type: 'service';
    /**
     * 表单项集合
     */
    controls?: Array<FormControlSchema>;
    /**
     * @deprecated 请用类型 tabs
     */
    tabs?: any;
    /**
     * @deprecated 请用类型 fieldSet
     */
    fieldSet?: any;
}
export declare class ServiceRenderer extends BasicService {
    static propsList: Array<string>;
    static contextType: React.Context<IScopedContext>;
    componentWillMount(): void;
    componentDidMount(): void;
    componentDidUpdate(prevProps: ServiceProps): void;
    componentWillUnmount(): void;
    afterDataFetch(payload: Payload): void;
    afterSchemaFetch(schema: any): void;
    isFormMode(): any;
    renderBody(): JSX.Element;
}
